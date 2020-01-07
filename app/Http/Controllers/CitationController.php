<?php

namespace App\Http\Controllers;

use App\Models\ApproximateDate;
use App\Models\CitationStatus;
use App\Models\Era;
use App\Models\Citation;
use App\Models\NounNature;
use App\Models\ScientificDomain;
use App\Models\Source;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request;
use App\Exceptions\APIException;
use Illuminate\Support\Facades\DB;
use App\Rules\CitationDateFormat;
use Illuminate\Support\Facades\Auth;


class CitationController extends Controller
{

      /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws APIException
     */
    public function get($wordId, $id)
    {
        $model = Citation::where(['word'=> $wordId,'id'=> $id])->first();

        if(!$model){
            throw new APIException('Citation not found.', APIException::NOT_FOUND);
        }

        $model->status;

        return response()->json($model);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws APIException
     */
    public function citationList($wordId)
    {
        try{
            DB::beginTransaction();
            $model = Citation::where(['word' => $wordId])->orderBy('created_at', 'asc')->get();
            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json($model);
    }


    /**
     * @param $wordId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getOptionsForWord($wordId)
    {
        $out = [
            'source'            => Source::all(),
            'eras'              => Era::all(),
            'approximatelyDate' => ApproximateDate::all(),
            'scientificDomains' => ScientificDomain::all(),
            'nounNatures'       => NounNature::all(),
            'status'            => Status::all(),
            'alaIm'         => [
                'baseUrl'       => env('MI_BASE_URL'),
                'browseUrl'     => env('MI_BROWSE_URL'),
            ],
        ];

        return response()->json($out);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function add($wordId, Request $request)
    {
        $model = $this->addOrUpdateCitation($request, $wordId);

        if($model->insert($request)){
            return $this->get($wordId, $model->id);
        }else{
            return response()->json('Creation failed!',500);
        }
    }


    public function citationUpdate(Request $request, $wordId, $id)
    {
        $model = Citation::where(['word'=> $wordId,'id'=> $id])->first();
        $model = $this->addOrUpdateCitation($request, $wordId, $model);

        if($model->updateCitation($request)){
            return $this->get($wordId, $model->id);
        }else{
            return response()->json('Update failed!', 500);
        }
    }


    public function addOrUpdateCitation(Request $request, $word = null, $model = null)
    {

        if(!$model)
            $model = new Citation();

        $this->validate($request, [
            'citation'          => 'string',
            'scientificDomain'  => 'array',
            'source'            => 'array',
            'approximate'       => 'nullable|array',
            'approximate.id'    => 'nullable|integer',
            'era'               => 'array',
            'nounNature'        => 'array',
            'bibliographicInfo' => 'string',
            'meaning'           => 'string',
            'miItem'            => 'required|integer',
            'miPage'            => 'required|integer',
            'miReference'       => 'required|array',
            'gregorianDateFrom' => new CitationDateFormat,
            'gregorianDateTo'   => new CitationDateFormat,
            'hijriDateFrom'     => new CitationDateFormat,
            'hijriDateTo'       => new CitationDateFormat,
            'status'            => 'array',
            'status.id'         => 'integer'
        ]);

        $model->word                = $word;
        $model->citation            = $request['citation'];
        $model->source              = $request['source']['id'];

        $model->gregorian_date_from   = $request['gregorianDateFrom'];
        $model->gregorian_date_to     = $request['gregorianDateTo'];
        $model->hijri_date_from       = $request['hijriDateFrom'];
        $model->hijri_date_to         = $request['hijriDateTo'];
        $model->approximate         = $request['approximate']['id'];

        $model->era                 = $request['era']['id'];
        $model->bibliographicInfo   = strip_tags($request['bibliographicInfo']);
        $model->meaning             = $request['meaning'];

        $model->miItem              = $request['miItem'];
        $model->miPage              = $request['miPage'];
        $model->miReference         = json_encode($request['miReference']);

        return $model;
    }

    /**
     * @param Request $request
     * @param $wordId
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function citationDelete(Request $request, $wordId, $id)
    {
        try{
            $model = Citation::where(['word' => $wordId, 'id' => $id])->first();

            if(!$model)
                throw new APIException('Citation not found.', APIException::NOT_FOUND);

            $model->delete();

        } catch (\Exception $e){
            throw $e;
        }

        return response()->json('Citation deleted!', 200);
    }

}
