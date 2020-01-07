<?php

namespace App\Http\Controllers;

use App\Models\WordActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordActivityController extends Controller
{
    public function getAllWordActivities($wordId){
        try{
            DB::beginTransaction();

            $wordActivites = WordActivity::where('word', $wordId)->orderBy('created_at', 'asc')->get();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json($wordActivites, 200);
    }

    public function createWordActivity($wordId, Request $request){
        try{
            DB::beginTransaction();

            $this->validateJson($request);
            $wordActivity = $this->createOrUpdateWordActivity($request, $wordId);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json(WordActivity::find($wordActivity->id), 200);
    }

    public function updateWordActivity($wordId, $wordActivityId, Request $request){
        try{
            DB::beginTransaction();

            $this->validateJson($request);

            $wordActivity = WordActivity::find($wordActivityId);

            $wordActivity = $this->createOrUpdateWordActivity($request, $wordId, $wordActivity);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($wordActivity->refresh(), 200);
    }

    public function deleteWordActivity($wordId, $wordActivityId){
        try{
            DB::beginTransaction();

            $wordActivity = WordActivity::findOrFail($wordActivityId);

            $wordActivity->delete();

            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response(null, 200);
    }

    //=======================================================

    private function validateJson(Request $request){
        $this->validate($request,[
            'content' => 'required|string'
        ]);
    }

    private function createOrUpdateWordActivity(Request $request, $wordId, WordActivity $wordActivity = null){
        if(!$wordActivity){
            $wordActivity = new WordActivity();
        }

        $wordActivity->word     = $wordId;
        if(Auth::check()){
            $wordActivity->user = Auth::user()->id;
        } else {
            $wordActivity->user = null;
        }
        $wordActivity->type     = WordActivity::COMMENT;
        $wordActivity->content  = $request->content;
        $wordActivity->data     = null;

        $wordActivity->save();

        return $wordActivity;
    }
}
