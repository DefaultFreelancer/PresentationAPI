<?php

namespace App\Http\Controllers;

use App\Models\Root;
use App\Models\Word;
use App\Models\WordType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordTableController extends Controller
{
    public function getOptions(){
        $columns = array(
            array('id' => 'id', 'name' => 'Id', 'visible' => true, 'locked' => true, 'type' => 'integer', 'sortable' => true),
            array('id' => 'text', 'name' => 'Text', 'visible' => true, 'locked' => true, 'type' => 'string', 'sortable' => true),
            array('id' => 'root', 'name' => 'Root', 'visible' => true, 'locked' => false, 'type' => 'string', 'sortable' => true),
            array('id' => 'type', 'name' => 'Word Type', 'visible' => true, 'locked' => false, 'type' => 'string', 'sortable' => true),
            array('id' => 'createdAt', 'name' => 'Created', 'visible' => true, 'locked' => false, 'type' => 'date', 'sortable' => true),
            array('id' => 'updatedAt', 'name' => 'Updated', 'visible' => true, 'locked' => false, 'type' => 'date', 'sortable' => true),
            array('id' => 'description', 'name' => 'Description', 'visible' => true, 'locked' => true, 'type' => 'array', 'sortable' => false),
            array('id' => 'actions', 'name' => 'Action', 'visible' => true, 'locked' => true, 'type' => 'action', 'sortable' => false)
        );

        $bulkOptions = [
            ['url' => '/api/word/bulk/remove', 'method' => 'DELETE', 'label' => 'Delete', 'type' => 'item']
        ];

        $options = array(
            'columns'                 => $columns,
            'limit'                   => 20,
            'order'                   => array('column' => 'id', 'type' => 'ASC'),
            'bulk'                    => array(
                'column' => 'id',
                'options' => $bulkOptions,
            ),
            'filters'                 => array(),
            'secondaryFiltersVisible' => false,
            'download'                => array()
        );

        return response()->json($options);
    }

    public function getFilters(){
        $filters = array();

        //searching over roots
        $filters[] = array(
            'id'        => 'search',
            'type'      => 'search',
            'label'     => 'Search',
            'isPrimary' => true,
        );

        //roots
        /* 
         $roots = array();
         foreach(Root::all() as $root){
             $roots[] = array(
                 'id' => $root->id,
                 'label' => $root->root
             );
         }

         $filters[] = array(
             'id'        => 'root',
             'type'      => 'menu',
             'variant'   => 'checkbox',
             'label'     => 'Root',
             'icon'      => 'filter',
             'items'     => $roots,
             'isPrimary' => true,
         ); 
         */

        //types
        $wordTypes = array();
        foreach(WordType::all() as $wordType){
            $wordTypes[] = array(
                'id' => $wordType->id,
                'label' => $wordType->name
            );
        }

        $filters[] = array(
            'id'        => 'type',
            'type'      => 'menu',
            'variant'   => 'checkbox',
            'label'     => 'Word Type',
            'icon'      => 'filter',
            'items'     => $wordTypes,
            'isPrimary' => true,
        );

        return response()->json($filters);
    }

    public function search(Request $request){

        $this->validate($request, [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
            'filters.root' => 'array',
            'filters.type' => 'array'
        ]);

        $allowedFields = array('id', 'text', 'root', 'type', 'created_at', 'updated_at', "adjective_id", "noun_id", "verb_id", "infinitive_id"); 

        $sqlClauses = array();

        //if search filter is set
        if(isset($request->filters['search']) && $request->filters['search'] != ""){
            $sqlClauses[] = sprintf("text like '%%%s%%'", $request->filters['search']);
        }

        //if root filter is set
        if(isset($request->filters['root'])){
            if(count($request->filters['root'])>0){
                $rootList = sprintf("(%s)",implode(",",$request->filters['root']));
                $sqlClauses[] = sprintf("root IN %s", $rootList);
            }
        }

        //if pattern filter is set
        if(isset($request->filters['type'])){
            if(count($request->filters['type'])>0){
                $patternList = sprintf("(%s)",implode(",",$request->filters['type']));
                $sqlClauses[] = sprintf("type IN %s", $patternList);
            }
        }

        $rawSQL = "";
        $rawSQL .= implode(" AND ", $sqlClauses);

        $limit = min(max(0, (int)$request->limit), 100);
        $offset = (int)$request->offset;

        if (count($sqlClauses) > 0) {
            $count = Word::select()->whereRaw(DB::raw($rawSQL))->get()->count();
        } else {
            $count = Word::select()->get()->count();
        }

        //implement sorting
        $allowedOrderTypes = ['ASC', 'DESC'];
        $allowedOrderColumns = ['id', 'text', 'createdAt', 'updatedAt', 'type', 'root'];
        //default order
        $orderType = "ASC";
        $orderColumn = "id";

        if(isset($request->order['column']) && isset($request->order['type'])){
            if(in_array($request->order['column'], $allowedOrderColumns) && in_array($request->order['type'], $allowedOrderTypes)){
                //$rawSQL .= sprintf(" ORDER BY %s %s", $request->order['column'], $request->order['type']);
                $orderType = $request->order['type'];
                if($request->order['column'] == "createdAt"){
                    $orderColumn = "created_at";
                }else if($request->order['column'] == "updatedAt"){
                    $orderColumn = "updated_at";
                }else {
                    $orderColumn = $request->order['column'];
                }
                
            }
            $rawSQL .= sprintf(" ORDER BY %s %s", $orderColumn, $orderType);
        }

        $rawSQL .= sprintf(" OFFSET %d LIMIT %d", $offset, $limit);

        if (count($sqlClauses) > 0) {
            $data = Word::select($allowedFields)->whereRaw(DB::raw($rawSQL))->get();
        } else {
            $data = Word::select($allowedFields)->orderBy($orderColumn, $orderType)->offset($offset)->limit($limit)->get();
        }

        $dataOut = array();
  
        foreach($data as $record){
            $recordArr = $record->toArray();

            if(isset($recordArr['root'])){
                $recordArr['root'] = $recordArr['root']['root'];
            }
            if(isset($recordArr['type'])){
                $recordArr['type'] = $recordArr['type']['name'];
            }

            $recordArr['description'] = $this->getWordDescription($record); //$this->getWordDescription($recordArr['id']);

            //removed not needed data from array
            unset($recordArr['noun']);
            unset($recordArr['infinitive']);
            unset($recordArr['adjective']);
            unset($recordArr['verb']);

            $actions = [
                [
                    'label'         => 'Edit',  // Not required
                    'method'        => 'GET',   // GET | DELETE | ...
                    'icon'          => 'edit outline', // Semnatic UI icon name, https://react.semantic-ui.com/elements/icon/
                    'confirm'       => false, // Weather action needs to be confirmed
                    // 'confirmLabel'  => '', // Optional, what's the label of confirm
                    'refresh'       => false, // Weather table needs to be refreshed after action call
                    'url'           => sprintf('/edit/%d', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
                    'target'        => '_self',
                ],
                [
                    'label'         => 'Delete',  // Not required
                    'method'        => 'DELETE',   // GET | DELETE | ...
                    'icon'          => 'trash alternate', // Semnatic UI icon name, https://react.semantic-ui.com/elements/icon/
                    'confirm'       => true, // Weather action needs to be confirmed
                    'confirmLabel'  => 'Really delete?', // Optional, what's the label of confirm
                    'refresh'       => true, // Weather table needs to be refreshed after action call
                    'url'           => sprintf('/api/word/%d', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
                    'target'        => '_self',
                ],
                [
                    'label'         => 'Data Entry',  // Not required
                    'method'        => 'GET',   // GET | DELETE | ...
                    'icon'          => 'database', // Semnatic UI icon name, https://react.semantic-ui.com/elements/icon/
                    'confirm'       => false, // Weather action needs to be confirmed
                    // 'confirmLabel'  => 'Really delete?', // Optional, what's the label of confirm
                    'refresh'       => false, // Weather table needs to be refreshed after action call
                    'url'           => sprintf('/word/%d/data-entry', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
                    'target'        => '_self',
                ],
                [
                    'label'         => 'Log',  // Not required
                    'method'        => 'GET',   // GET | DELETE | ...
                    'icon'          => 'comments', // Semnatic UI icon name, https://react.semantic-ui.com/elements/icon/
                    'confirm'       => false, // Weather action needs to be confirmed
                    // 'confirmLabel'  => 'Really delete?', // Optional, what's the label of confirm
                    'refresh'       => false, // Weather table needs to be refreshed after action call
                    'url'           => sprintf('/log/%d', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
                    'target'        => '_self',
                ],
            ];

            $recordArr['actions'] = $actions;
            $dataOut[] = $recordArr;
        }


        $out = array(
            'result'  => $dataOut,
            'count'   => $count
        );

        return response()->json($out);
    }

    private function getWordDescription($word){
        
        $description = array();
        $wordArr = $word->toArray();
        
        if($word->getType()){

            switch($word->getType()){
                case 1: //noun
                    $description['Plural'] = $wordArr['noun']['plural'];
                    $description['Plural type'] = $wordArr['noun']['classPlural']['text'];
                    break;
                case 2: //verb
                    break;
                case 3: //adjective
                    $description['Past Participl'] = $wordArr['adjective']['pastParticiple'];
                    $description['Assimilated'] = $wordArr['adjective']['assimilated'];
                    $description['Mobalagha'] = $wordArr['adjective']['mobalagha'];
                    $description['Period Participle'] = $wordArr['adjective']['periodParticiple'];
                    $description['Place Participle'] = $wordArr['adjective']['placeParticiple'];
                    $description['Machine Participle'] = $wordArr['adjective']['machineParticiple'];
                    break;
                case 4: //infinitive
                    $description['Hayaah'] = $wordArr['infinitive']['hayaah'];
                    $description['Time'] = $wordArr['infinitive']['infTime'];
                    $description['Meme'] = $wordArr['infinitive']['meme'];
                    $description['Making'] = $wordArr['infinitive']['making'];
                    break;
            }
            
        }

        return $description;

    }
}
