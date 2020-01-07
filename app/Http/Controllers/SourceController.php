<?php

namespace App\Http\Controllers;

use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{

    public function getAll()
    {
        return response()->json(Source::get(), 200);
    }


    public function get($id)
    {
        $model = Source::get();
        if($id){
            $model = Source::find($id);
        }

        return response()->json($model, 200);
    }


    public function create(Request $request)
    {
        $this->validate($request,[
            'source' => 'required|string'
        ]);

        $model = new Source();
        $model->source = $request['source'];
        $model->save();

        return response()->json('Source created! ',200);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'source' => 'required|string'
        ]);

        try{
            $model = Source::find($id);
            $model->source = $request['source'];
            $model->save();
        } catch (\Exception $e){
            return response()->json('Update failed!', 404);
        }

        return response()->json('Source updated!', 200);
    }


    public function delete(Request $request, $id)
    {
        try{
            $model = Source::find($id);
            $model->delete();
        } catch (\Exception $e){
            return response()->json('Delete failed!', 500);
        }

        return response()->json('Deleted successfully!', 200);
    }

}
