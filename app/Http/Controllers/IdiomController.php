<?php

namespace App\Http\Controllers;

use App\Models\Idiom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdiomController extends Controller
{
    private $limit = 20;

    public function getAllIdioms(){
        try{
            DB::beginTransaction();

            $idioms = Idiom::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($idioms);
    }

    public function getOneIdiom($id){
        try{
            DB::beginTransaction();

            $idiom = Idiom::findOrFail($id);

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($idiom);
    }

    public function createIdiom(Request $request){
        try{
            DB::beginTransaction();
            $this->validateJson($request);

            $idiom = $this->addOrUpdateIdiom($request);

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($idiom->fresh()->toArray(), 200);
    }

    public function updateIdiom($id, Request $request){
        try{
            DB::beginTransaction();
            $this->validateJson($request);

            $idiom = Idiom::findOrFail($id);
            $idiom = $this->addOrUpdateIdiom($request, $idiom);

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($idiom->refresh(), 200);
    }

    public function deleteIdiom($id){
        try{
            DB::beginTransaction();

            $idiom = Idiom::findOrFail($id);

            $idiom->delete();

            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response(null, 200);
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

        $idioms = Idiom::where('text', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();

        return response()->json($idioms);
    }

    //==========================================

    private function validateJson(Request $request){
        $this->validate($request, [
            'text' => 'required|max:255',
            'root.id' => 'required|integer',
            'word.id' => 'required|integer'
        ]);
    }

    private function addOrUpdateIdiom(Request $request, Idiom $idiom = null){

        if(!$idiom){
            $idiom = new Idiom();
        }

        $idiom->text = $request->text;
        $idiom->root = $request->root['id'];
        $idiom->word = $request->word['id'];
        $idiom->save();
        return $idiom;
    }
}
