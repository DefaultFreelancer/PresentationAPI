<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Root;
//use App\Models\Pattern;
use App\Models\RootClass;
use App\Models\RootStatus;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class RootController extends Controller
{
    private $limit = 20;

    public function getAllRoots()
    {
      return response()->json(Root::all());
    }


    public function options()
    {
        return response()->json(['status' => Status::all()]);
    }


    public function getOneRoot($id)
    {
      $root = Root::findOrFail($id);
      return response()->json($root);
    }


    public function createRoot(Request $request)
    {
      $this->validate($request, [
        'root' => 'required',
        'rootClass.id' => 'integer|nullable',
        //'pattern.id' => 'required',
        //'status'     => 'array',
        //'status.id'  => 'integer',
        'rootStatus.status.id'  => 'integer|nullable'
      ]);

      //$root = new Root;
      //$root->root = $request->root;
      //$root->class_id = $request->rootClass['id'] ?? null;
      //$root->pattern_id = $request->pattern['id'];
      //$root->save();

      //RootStatus::create($root->id, Auth::user()->id,  (array_key_exists('status', $request->all()) ? $request['status']['id'] : ''));

      $root = $this->addOrUpdateRoot($request);

      return response()->json($root);
    }


    public function updateRoot($id, Request $request)
    {
      $this->validate($request, [
        'root' => 'required',
        'rootClass.id' => 'integer|nullable',
        //'pattern.id' => 'required',
        //'status'     => 'array',
        //'status.id'  => 'integer',
        'rootStatus.status.id'  => 'integer|nullable'
      ]);

      $root = Root::find($id);
      //$root->root = $request->root;
      //$root->class_id = $request->rootClass['id'] ?? null;
      //$root->pattern_id = $request->pattern['id'];
      //$root->save();

      //RootStatus::create($root->id, Auth::user()->id,  (array_key_exists('status', $request->all()) ? $request['status']['id'] : ''));
      
      $root = $this->addOrUpdateRoot($request, $root);
      
      return response()->json($root);
    }

    private function addOrUpdateRoot($request, $root = null){
      if(!$root){
        $root = new Root;
      }

      $root->root = $request->root;
      $root->class_id = $request->rootClass['id'] ?? null;
      //$root->pattern_id = $request->pattern['id'];
      $root->save();

      //RootStatus::create($root->id, Auth::user()->id,  (array_key_exists('status', $request->all()) ? $request['status']['id'] : ''));
      RootStatus::create($root->id, Auth::user()->id, isset($request["rootStatus"]["status"]["id"]) ? $request["rootStatus"]["status"]["id"] : null);
      return $root->fresh();

    }


    public function deleteRoot($id)
    {
      Root::findOrFail($id)->delete(); // This just deletes the data if is there
      return response('Deleted Successfully', 200);
    }


    public function bulkDeleteRoot(Request $request){
      $rootIds = $request->json()->all();

      Root::destroy($rootIds);
      return response('Deleted Successfully', 200); 
    }


    public function autocomplete(Request $request){
        $this->validate($request, [
            'input' => 'required|string|min:1',
            'limit' => 'numeric|min:5|max:100'
        ]);

        $input = $request->input('input');
        $limit = $request->input('limit');
        if(!empty($limit)){
            $this->limit = (int)$limit;
        }

        $roots = Root::where('root', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();

        return response()->json($roots);
    }
}

