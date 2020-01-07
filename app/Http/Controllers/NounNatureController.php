<?php

namespace App\Http\Controllers;

use App\NounNature;
use Illuminate\Http\Request;

class NounNatureController extends Controller
{


    public function getAll()
    {
        return response()->json(NounNature::get(), 200);
    }


    public function get($id)
    {
        $model = NounNature::get($id);
        if($id){
            $model = NounNature::find($id);
        }
        return response()->json($model, 200);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'nature' => 'required|string'
        ]);

        $model = new NounNature();
        $model->nature = $request['nature'];
        $model->save();

        return response()->json('Noun Nature created!',200);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'nature' => 'required|string'
        ]);

        try{
            $model = NounNature::find($id);
            $model->nature = $request['nature'];
            $model->save();
        } catch (\Exception $e){
            return response()->json('Update failed!', 404);
        }

        return response()->json('Noun Nature updated!', 200);
    }


    public function delete(Request $request, $id)
    {
        try{
            $model = NounNature::find($id);
            $model->delete();
        } catch (\Exception $e){
            return response()->json('Delete failed!', 500);
        }

        return response()->json('Deleted successfully!', 200);
    }

}
