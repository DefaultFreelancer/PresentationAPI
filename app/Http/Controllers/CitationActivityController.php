<?php

namespace App\Http\Controllers;

use App\Models\CitationActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitationActivityController extends Controller
{
    public function getAllCitationActivities($citationId){
        try{
            DB::beginTransaction();

            $citationActivites = CitationActivity::where('citation', $citationId)->orderBy('created_at', 'asc')->get();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json($citationActivites, 200);
    }

    public function createCitationActivity($wordId, $citationId, Request $request){
        try{
            DB::beginTransaction();

            $this->validateJson($request);
            $citationActivity = $this->createOrUpdateCitationActivity($request, $citationId);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json(CitationActivity::find($citationActivity->id), 200);
    }

    public function updateCitationActivity($wordId, $citationId, $citationActivityId, Request $request){
        try{
            DB::beginTransaction();

            $citationActivity = CitationActivity::find($citationActivityId);
            $this->validateJson($request);
            $citationActivity = $this->createOrUpdateCitationActivity($request, $citationId, $citationActivity);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($citationActivity->refresh(), 200);
    }

    public function deleteCitationActivity($wordId, $citationId, $citationActivityId){
        try{
            DB::beginTransaction();

            $citationActivity = CitationActivity::findOrFail($citationActivityId);

            $citationActivity->delete();

            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response(null, 200);
    }

    //============================================

    private function validateJson(Request $request){
        $this->validate($request,[
            'content' => 'required|string'
        ]);
    }

    private function createOrUpdateCitationActivity(Request $request, $citationId, CitationActivity $citationActivity = null){
        if(!$citationActivity){
            $citationActivity = new CitationActivity();
        }

        $citationActivity->citation = $citationId;
        if(Auth::check()){
            $citationActivity->user = Auth::user()->id;
        } else {
            $citationActivity->user = null;
        }
        $citationActivity->type     = CitationActivity::COMMENT;
        $citationActivity->content  = $request->content;
        $citationActivity->data     = null;

        $citationActivity->save();

        return $citationActivity;
    }
}
