<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Citation extends BaseModel
{
    protected $with = ['word','source','era','approximate','scientificDomain','nounNature','citationStatus'];
    protected $appends = ['image_src', 'view_href','status'];

    public function getGregorianDateFromAttribute($value){
        return $this->dateIntToString($value);
    }
    public function getGregorianDateToAttribute($value){
        return $this->dateIntToString($value);
    }
    public function getHijriDateFromAttribute($value){
        return $this->dateIntToString($value);
    }
    public function getHijriDateToAttribute($value){
        return $this->dateIntToString($value);
    }

    public function setGregorianDateFromAttribute($value){
        $this->attributes['gregorian_date_from'] = $this->dateStringToInt($value);
    }
    public function setGregorianDateToAttribute($value){
        $this->attributes['gregorian_date_to'] = $this->dateStringToInt($value);
    }
    public function setHijriDateFromAttribute($value){
        $this->attributes['hijri_date_from'] = $this->dateStringToInt($value);
    }
    public function setHijriDateToAttribute($value){
        $this->attributes['hijri_date_to'] = $this->dateStringToInt($value);
    }

    public function getImageSrcAttribute()
    {
        // https://ala-mi.dev.milivojeivic.com/api/item/2/citation-image/18/0,0,100,100/full/0/default.jpg


        $x = $y = $w = $h = 0;
        $wordUuid = null;

        try {

            $reference = json_decode($this->miReference);

            $Xs = [];
            $Ys = [];

            foreach($reference->polygon as $point){
                $Xs[] = $point[0];
                $Ys[] = $point[1];
            }

            $x = min($Xs);
            $y = min($Ys);

            $w = max($Xs) - $x;
            $h = max($Ys) - $y;

            $wordUuid = $reference->wordUuid;

        } catch (\Exception $e){
            return null;
        }

        if(($x == 0 && $y == 0 && $w == 0 && $h == 0) || $wordUuid == null){
            return null;
        }

        return sprintf('%s/item/%d/citation-image/%d/%d,%d,%d,%d/%s/300,/0/default.jpg', env('MI_API'), $this->miItem, $this->miPage, $x, $y, $w, $h, $wordUuid);
    }

    public function getViewHrefAttribute()
    {
        return sprintf('%s', env('MI_UI'));
    }

    private function dateIntToString($int){
        $year = (int)($int/10000);
        $month = (int)((int)($int/100))%100;
        $day = (int)$int%100;

        if($year == 0)
            return null;

        if($month == 0 && $day == 0)
            return sprintf('%d', $year);

        return sprintf('%d-%02d-%02d', $year, $month, $day);
    }

    private function dateStringToInt($str){

        if(preg_match('/^(-?\d+)-(\d{1,2})-(\d{1,2})$/', $str, $match)){

            $year  = (int)$match[1];
            $month = (int)$match[2];
            $day   = (int)$match[3];

            return $year * 10000 + $month * 100 + $day;

        } else if(preg_match('/^(-?\d+)$/', $str, $match)){
            $year  = (int)$match[1];

            return $year * 10000;
        }

        return 0;
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        try{
            $this->save();
            if(!$this->updateRelation($data, $this->id)){
                $this->delete();
            }

        } catch (\Exception $e){
            throw $e;
        }

        // This number 1 in the middle will ge replaced with user ID, when authorisation is implemented on this part // Auth::user()->id
        CitationStatus::create($this->word, Auth::user()->id,(array_key_exists('status',$data->all()) ? $data['status']['id'] : null));
        return true;
    }


    /**
     * @param $data
     * @return bool
     */
    public function updateCitation($data)
    {
        try{
            $this->save();
            if(!$this->updateRelation($data, $this->id)){
                $this->delete();
            }
        } catch (\Exception $e){
            throw $e;
        }

        // This number 1 in the middle will ge replaced with user ID, when authorisation is implemented on this part // Auth::user()->id
        CitationStatus::create($this->word, Auth::user()->id,(array_key_exists('status',$data->all()) ? $data['status']['id'] : null));
        return true;
    }

    /**
     * @param $relation
     * @param $id
     * @param $type
     */
    public function updateRelation($data, $id){
        if(count($data->all())){
            if (array_key_exists("nounNature",$data->all())){
                if(count($data['nounNature'])){
                    try{
                        NounNatureCitation::where(['citation_id' => $this->id])->delete();
                        foreach ($data['nounNature'] as $nature){
                            NounNatureCitation::create($id, $nature['id']);
                        }
                    } catch (\Exception $e){
                        throw $e;
                    }
                }
            }
            if (array_key_exists("scientificDomain",$data->all())){
                if(count($data['scientificDomain'])){
                    try{
                        ScientificDomainCitation::where(['citation_id' => $this->id])->delete();
                        foreach ($data['scientificDomain'] as $domain){
                            ScientificDomainCitation::create($id, $domain['id']);
                        }
                    } catch (\Exception $e){
                        throw $e;
                    }
                }
            }
        }
        return true;
    }


    public function getStatusAttribute(){
        if($this->citationStatus){
            if($this->citationStatus->status){
                return $this->citationStatus->status;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function word()
    {
        return $this->hasOne(Word::class, 'id','word');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function source()
    {
        return $this->hasOne(Source::class, 'id','source');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function era()
    {
        return $this->hasOne(Era::class, 'id','era');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approximate()
    {
        return $this->hasOne(ApproximateDate::class, 'id','approximate');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scientificDomain()
    {
        return $this->belongsToMany(ScientificDomain::class, 'scientific_domain_citations', 'citation_id', 'domain_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nounNature()
    {
        return $this->belongsToMany(NounNature::class, 'noun_nature_citations', 'citation_id', 'nature_id');
    }


    public function citationStatus()
    {
        return $this->hasOne(CitationStatus::class, 'word_id','word')->orderBy('created_at','desc');
    }

}
