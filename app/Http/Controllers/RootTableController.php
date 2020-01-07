<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Root;
//use App\Models\Pattern;
use App\Models\RootClass;
use App\Models\Word;

class RootTableController extends Controller
{

    public function getOptions()
    {
      $columns = array(
        array('id' => 'id', 'name' => 'Id', 'visible' => true, 'locked' => false, 'type' => 'integer', 'sortable' => true),
        array('id' => 'root', 'name' => 'root', 'visible' => true, 'locked' => false, 'type' => 'string', 'sortable' => true),
        //array('id' => 'pattern', 'name' => 'Pattern', 'visible' => true, 'locked' => false, 'type' => 'string', 'sortable' => false),
        array('id' => 'rootClass', 'name' => 'Class', 'visible' => true, 'locked' => false, 'type' => 'string', 'sortable' => true),
        array('id' => 'createdAt', 'name' => 'Created', 'visible' => true, 'locked' => false, 'type' => 'date', 'sortable' => true),
        array('id' => 'updatedAt', 'name' => 'Updated', 'visible' => true, 'locked' => false, 'type' => 'date', 'sortable' => true),
        array('id' => 'actions', 'name' => 'Action', 'visible' => true, 'locked' => true, 'type' => 'action', 'sortable' => false)
      );

      $bulkOptions = [
        ['url' => '/api/root/bulk/remove', 'method' => 'DELETE', 'label' => 'Delete', 'type' => 'item']
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

    public function getFilters()
    {
      $filters = array();

      //searching over roots
      $filters[] = array(
        'id'        => 'search',
        'type'      => 'search',
        'label'     => 'Search',
        'isPrimary' => true,
      );

      //classes
      $classes = array();
      foreach(RootClass::all() as $rootClass){
        $classes[] = array(
          'id' => $rootClass->id,
          'label' => $rootClass->class
        );
      }

      $filters[] = array(
        'id'        => 'class',
        'type'      => 'menu',
        'variant'   => 'checkbox',
        'label'     => 'Class',
        'icon'      => 'filter',
        'items'     => $classes,
        'isPrimary' => true,
      );

      //patterns
      //$patterns = array();
      //foreach(Pattern::all() as $value){
      //  $patterns[] = array(
      //    'id' => $value->id,
      //    'label' => $value->text
      //  );
      //}

      /* $filters[] = array(
          'id'        => 'pattern',
          'type'      => 'menu',
          'variant'   => 'checkbox',
          'label'     => 'Pattern',
          'icon'      => 'filter',
          'items'     => $patterns,
          'isPrimary' => true,
      ); */

      return response()->json($filters);
    }

    public function search(Request $request)
    {

      $this->validate($request, [
        'limit' => 'required|integer',
        'offset' => 'required|integer',
        'filters.class' => 'array',
        //'filters.pattern' => 'array'
      ]);

      //$allowedFields = array('id', 'root', 'pattern_id', 'class_id', 'created_at', 'updated_at');
      $allowedFields = array('id', 'root', 'class_id', 'created_at', 'updated_at');

      $sqlClauses = array();

      //if search filter is set
      if(isset($request->filters['search'])){
        $sqlClauses[] = sprintf("root like '%%%s%%'", $request->filters['search']);
      }

      //if class filter is set
      if(isset($request->filters['class'])){
        if(count($request->filters['class'])>0){
          $classList = sprintf("(%s)",implode(",",$request->filters['class']));
          $sqlClauses[] = sprintf("class_id IN %s", $classList);
        }
      }

      //if pattern filter is set
      //if(isset($request->filters['pattern'])){
      //  if(count($request->filters['pattern'])>0){
      //    $patternList = sprintf("(%s)",implode(",",$request->filters['pattern']));
      //    $sqlClauses[] = sprintf("pattern_id IN %s", $patternList);
      //  }
      //}

      $rawSQL = "";
      $rawSQL .= implode(" AND ", $sqlClauses);

      $limit = min(max(0, (int)$request->limit), 100);
      $offset = (int)$request->offset;

      if (count($sqlClauses) > 0) {
        $count = Root::select()->whereRaw(DB::raw($rawSQL))->get()->count();
      } else {
        $count = Root::select()->get()->count();
      }

      //sorting
      $allowedOrderTypes = ['ASC', 'DESC'];
      $allowedOrderColumns = ['id', 'root' , 'rootClass', 'createdAt', 'updatedAt'];
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
        $data = Root::select($allowedFields)->whereRaw(DB::raw($rawSQL))->get();
      } else {
        $data = Root::select($allowedFields)->orderBy($orderColumn, $orderType)->offset($offset)->limit($limit)->get();
      }
      
      $dataOut = array();

      foreach($data as $record){
        $recordArr = $record->toArray();

        //if(isset($recordArr['pattern'])){
        //  $recordArr['pattern'] = $recordArr['pattern']['text'];
        //}
        if(isset($recordArr['rootClass'])){
          $recordArr['rootClass'] = $recordArr['rootClass']['class'];
        }

        //counts number of words per root
        $wordCount = Word::where('root', '=', $record->id)->count();

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
                'url'           => sprintf('/api/root/%d', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
                'target'        => '_self',
            ],
            [
                'label'         => sprintf('Words (%d)', $wordCount),  // Not required
                'method'        => 'GET',   // GET | DELETE | ...
                'icon'          => 'eye', // Semnatic UI icon name, https://react.semantic-ui.com/elements/icon/
                'confirm'       => false, // Weather action needs to be confirmed
                // 'confirmLabel'  => 'Really delete?', // Optional, what's the label of confirm
                'refresh'       => false, // Weather table needs to be refreshed after action call
                'url'           => sprintf('/roots/%d/words', $record->id), // URLs, PUT,DELETE,POST called with AXIOS, GET with router to=""
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


}

