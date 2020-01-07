<?php

namespace App\Http\Controllers;

use App\ScientificDomain;
use Illuminate\Http\Request;

class ScientificDomainController extends Controller
{

    public function getAll()
    {
        return response()->json(ScientificDomain::get(), 200);
    }


    public function get($id)
    {
        $model = ScientificDomain::get();
        if($id){
            $model = ScientificDomain::find($id);
        }

        return response()->json($model, 200);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'model' => 'required|string'
        ]);

        $model = new ScientificDomain();
        $model->model = $request['model'];
        $model->save();

        return response()->json('Scintific Domain created! ',200);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required|string'
        ]);

        try{
            $model = ScientificDomain::find($id);
            $model->model = $request['model'];
            $model->save();
        } catch (\Exception $e){
            return response()->json('Update failed!', 404);
        }

        return response()->json('Scintific Domain updated!', 200);
    }


    public function delete(Request $request, $id)
    {
        try{
            $model = ScientificDomain::find($id);
            $model->delete();
        } catch (\Exception $e){
            return response()->json('Delete failed!', 500);
        }

        return response()->json('Deleted successfully!', 200);
    }
}
