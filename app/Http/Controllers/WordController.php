<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\WordType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\AdjectiveTypePattern;
use App\Models\NounAttribution;
use App\Models\NounClassPlural;
use App\Models\NounMinimize;
use App\Models\NounSex;
use App\Models\NounSexHow;
use App\Models\NounType;
use App\Models\VerbPhonologicalRule;
use App\Models\VerbSyntaxicalRule;
use App\Models\Pattern;
use App\Models\Verb;
use App\Models\Noun;
use App\Models\Adjective;
use App\Models\Infinitive;


class WordController extends Controller
{
    private $limit = 20;

    public function getAllWords(){
        try{
            DB::beginTransaction();

            $words = Word::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($words);
    }

    public function getOneWord($id){
        try{
            DB::beginTransaction();

            $word = Word::findOrFail($id);

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($word);
    }

    public function createWord(Request $request){
        
        $word = $this->addOrUpdateWord($request);
        return response()->json(Word::find($word->id), 200);
    }

    public function updateWord($id, Request $request){

        $word = Word::findOrFail($id);
        $word = $this->addOrUpdateWord($request, $word);
        return response()->json($word->refresh(), 200);

    }

    private function addOrUpdateWord($request, $word = null){

        $this->validate($request, [
            'text' => 'required|max:255',
            'root.id' => 'required|integer',
            'type.id' => 'required|integer',
        ]);

        /*$this->validate($request, [
            'text' => 'required|max:255',
            'root.id' => 'required|integer',
            'type.id' => 'required|integer',
            'noun.plural' => 'string|nullable',
            'noun.theWithNoun' => 'string|nullable',
            'noun.dualMale' => 'string|nullable',
            'noun.dualFemale' => 'string|nullable',
            'noun.pattern.id' => 'integer|nullable',
            'noun.type.id' => 'integer|nullable',
            'noun.classPlural.id' => 'integer|nullable',
            'noun.sex.id' => 'integer|nullable',
            'noun.sexHow.id' => 'integer|nullable',
            'noun.attribution.id' => 'integer|nullable',
            'noun.minimize.id' => 'integer|nullable',
            'noun.attributionText' => 'string|nullable',
            'noun.minimizeText' => 'string|nullable',
            'adjective.pastParticiple' => 'string|nullable',
            'adjective.assimilated' => 'string|nullable',
            'adjective.mobalagha' => 'string|nullable',
            'adjective.comperative' => 'string|nullable',
            'adjective.periodParticiple' => 'string|nullable',
            'adjective.placeParticiple' => 'string|nullable',
            'adjective.machineParticiple' => 'string|nullable',
            'adjective.verb' => 'string|nullable',
            'adjective.adjectivePattern.id' => 'integer|nullable',
            'adjective.typePattern.id' => 'integer|nullable',
            'adjective.patternPastParticiple.id' => 'integer|nullable',
            'adjective.patternAssimilated.id' => 'integer|nullable',
            'adjective.patternMobalagha.id' => 'integer|nullable',
            'adjective.patternComperative.id' => 'integer|nullable',
            'adjective.patternPeriodParticiple.id' => 'integer|nullable',
            'adjective.patternPlaceParticiple.id' => 'integer|nullable',
            'adjective.patternMachineParticiple.id' => 'integer|nullable',
            'adjective.patternVerb.id' => 'integer|nullable',
            'verb.pattern.id' => 'integer|nullable',
            'verb.verbPhonologicalRule.id' => 'integer|nullable',
            'verb.verbSyntaxicalRule.id' => 'integer|nullable',
            'infinitive.verb' => 'string|nullable',
            'infinitive.hayaah' => 'string|nullable',
            'infinitive.meme' => 'string|nullable',
            'infinitive.making' => 'string|nullable',
            'infinitive.infTime' => 'string|nullable',
            'infinitive.pattern.id' => 'integer|nullable',
            'infinitive.patternHayaah.id' => 'integer|nullable',
            'infinitive.patternMeme.id' => 'integer|nullable',
            'infinitive.patternMaking.id' => 'integer|nullable',
            'infinitive.patternTime.id' => 'integer|nullable',
        ]); */

        if(isset($request->noun) && $request->type['id'] == 1){
            $this->validate($request, [
                'noun.plural' => 'string|nullable',
                'noun.theWithNoun' => 'string|nullable',
                'noun.dualMale' => 'string|nullable',
                'noun.dualFemale' => 'string|nullable',
                'noun.female' => 'string|nullable',
                'noun.pattern.id' => 'required|integer',
                'noun.type.id' => 'integer|nullable',
                'noun.classPlural.id' => 'integer|nullable',
                'noun.sex.id' => 'integer|nullable',
                'noun.sexHow.id' => 'integer|nullable',
                'noun.attribution.id' => 'required|integer',
                'noun.minimize.id' => 'required|integer',
                'noun.attributionText' => 'required|string',
                'noun.minimizeText' => 'required|string',
            ]);

        }
        else if(isset($request->verb) && $request->type['id'] == 2){
            $this->validate($request, [
                'verb.pattern.id' => 'integer|nullable',
                'verb.verbPhonologicalRule.id' => 'required|integer',
                'verb.verbSyntaxicalRule.id' => 'required|integer',
            ]);
        }
        else if(isset($request->adjective) && $request->type['id'] == 3){
            $this->validate($request, [
                'adjective.pastParticiple' => 'required|string',
                'adjective.assimilated' => 'required|string',
                'adjective.mobalagha' => 'required|string',
                'adjective.comperative' => 'required|string',
                'adjective.periodParticiple' => 'required|string',
                'adjective.placeParticiple' => 'required|string',
                'adjective.machineParticiple' => 'required|string',
                'adjective.verb' => 'required|string',
                'adjective.adjectivePattern.id' => 'required|integer',
                'adjective.typePattern.id' => 'integer|nullable',
                'adjective.patternPastParticiple.id' => 'required|integer',
                'adjective.patternAssimilated.id' => 'required|integer',
                'adjective.patternMobalagha.id' => 'required|integer',
                'adjective.patternComperative.id' => 'required|integer',
                'adjective.patternPeriodParticiple.id' => 'required|integer',
                'adjective.patternPlaceParticiple.id' => 'required|integer',
                'adjective.patternMachineParticiple.id' => 'required|integer',
                'adjective.patternVerb.id' => 'required|integer',
            ]);
        }
        else if(isset($request->infinitive) && $request->type['id'] == 4){
            $this->validate($request, [
                'infinitive.verb' => 'string|nullable',
                'infinitive.hayaah' => 'string|nullable',
                'infinitive.meme' => 'required|string',
                'infinitive.making' => 'required|string',
                'infinitive.infTime' => 'required|string',
                'infinitive.pattern.id' => 'integer|nullable',
                'infinitive.patternHayaah.id' => 'integer|nullable',
                'infinitive.patternMeme.id' => 'required|integer',
                'infinitive.patternMaking.id' => 'integer|nullable',
                'infinitive.patternTime.id' => 'integer|nullable',
                'infinitive.patternVerb.id’ => ‘required|integer',
            ]);
        }


        try{
            
            //if word already exists check if the type of the word was changed
            //if the type of the word was changed remove the data from adjective || noun || infitinive || verb
/*            if($word && $word->type != $request->type['id']){
                if($word->adjective_id){
                    $id = $word->adjective_id;
                    $word->adjective_id = null;
                    $word->save();
                    Adjective::findOrFail($id)->delete();
                }
                if($word->noun_id){
                    $id = $word->noun_id;
                    $word->noun_id = null;
                    $word->save();
                    Noun::findOrFail($id)->delete();
                }
                if($word->infinitive_id){
                    $id = $word->infinitive_id;
                    $word->infinitive_id = null;
                    $word->save();
                    Infinitive::findOrFail($id)->delete();
                }
                if($word->verb_id){
                    $id = $word->verb_id;
                    $word->verb_id = null;
                    $word->save();
                    Verb::findOrFail($id)->delete();
                }
            }     */       
            
            if(!$word){
                $word = new Word();
            }
                        
            DB::beginTransaction();

            $word->text = $request->text;
            $word->root = $request->root['id'];
            //set type and remove relations if type is changed
            $word->setType($request->type['id']);

            if(isset($request->noun) && $request->type['id'] == 1){

                $noun = null;

                //if updating a word
                if(isset($word->noun_id)){
                    $noun = Noun::findOrFail($word->noun_id);
                }
                //if inserting a word
                else if(!$noun){
                    $noun = new Noun();
                }

                //update/insert noun data
                $noun->pattern_id = $request->noun['pattern']['id'] ?? null;
                $noun->type_id = $request->noun['type']['id'] ?? null;
                $noun->plural = $request->noun['plural'] ?? null;
                $noun->class_plural_id = $request->noun['classPlural']['id'] ?? null;
                $noun->pattern_plural_id = $request->noun['patternPlural']['id'] ?? null;
                $noun->the_with_noun = $request->noun['theWithNoun'] ?? null;
                $noun->sex_id = $request->noun['sex']['id'] ?? null;
                $noun->sex_how_id = $request->noun['sexHow']['id'] ?? null;
                $noun->dual_male = $request->noun['dualMale'] ?? null;
                $noun->dual_female = $request->noun['dualFemale'] ?? null;
                $noun->female = $request->noun['female'] ?? null;
                $noun->attribution_id = $request->noun['attribution']['id'] ?? null;
                $noun->minimize_id = $request->noun['minimize']['id'] ?? null;
                $noun->attribution_text = $request->noun['attributionText'] ?? null;
                $noun->minimize_text = $request->noun['minimizeText'] ?? null;
                $noun->save();
                
                //save noun id to word
                $word->noun_id = $noun->id;
            }
            else if(isset($request->verb) && $request->type['id'] == 2){
                
                $verb = null;

                //if updating a word
                if(isset($word->verb_id)){
                    $verb = Verb::findOrFail($word->verb_id);
                }
                //if inserting a word
                else if(!$verb){
                    $verb = new Verb();
                }
                
                //update/insert verb data
                $verb->pattern_id = $request->verb['pattern']['id'] ?? null;
                $verb->syntaxical_rule_id = $request->verb['verbSyntaxicalRule']['id'] ?? null;
                $verb->phonological_rule_id = $request->verb['verbPhonologicalRule']['id'] ?? null;
                $verb->save();

                //save verb id to word
                $word->verb_id = $verb->id;
                
            }
            else if(isset($request->adjective) && $request->type['id'] == 3){

                $adjective = null;

                //if updaing a word
                if(isset($word->adjective)){
                    $adjective = Adjective::findOrFail($word->adjective_id);
                }
                //if inserting a word
                else if(!$adjective){
                    $adjective = new Adjective();
                }
                
                //update/insert adjective data
                $adjective->adjective_pattern_id = $request->adjective['adjectivePattern']['id'] ?? null;
                $adjective->type_pattern_id = $request->adjective['typePattern']['id'] ?? null;
                $adjective->past_participle = $request->adjective['pastParticiple'] ?? null;
                $adjective->pattern_past_participle_id = $request->adjective['patternPastParticiple']['id'] ?? null;
                $adjective->assimilated = $request->adjective['assimilated'] ?? null;
                $adjective->pattern_assimilated_id = $request->adjective['patternAssimilated']['id'] ?? null;
                $adjective->mobalagha = $request->adjective['mobalagha'] ?? null;
                $adjective->pattern_mobalagha_id = $request->adjective['patternMobalagha']['id'] ?? null;
                $adjective->comperative = $request->adjective['comperative'] ?? null;
                $adjective->pattern_comperative_id = $request->adjective['patternComperative']['id'] ?? null;
                $adjective->period_participle = $request->adjective['periodParticiple'] ?? null;
                $adjective->pattern_period_participle_id = $request->adjective['patternPeriodParticiple']['id'] ?? null;
                $adjective->place_participle = $request->adjective['placeParticiple'] ?? null;
                $adjective->pattern_place_participle_id = $request->adjective['patternPlaceParticiple']['id'] ?? null;
                $adjective->machine_participle = $request->adjective['machineParticiple'] ?? null;
                $adjective->pattern_machine_participle_id = $request->adjective['patternMachineParticiple']['id'] ?? null;
                $adjective->verb = $request->adjective['verb'] ?? null;
                $adjective->pattern_verb_id = $request->adjective['patternVerb']['id'] ?? null;
                $adjective->save();

                //save adjective id to word
                $word->adjective_id = $adjective->id;
            }
            else if(isset($request->infinitive) && $request->type['id'] == 4){

                $infinitive = null;

                //if updating a word
                if(isset($word->infinitive_id)){
                    $infinitive = Infinitive::findOrFail($word->infinitive_id);
                }
                //if inserting a word
                else if(!$infinitive){
                    $infinitive = new Infinitive();
                }
                
                //update/insert infinitive data
                $infinitive->pattern_id = $request->infinitive['pattern']['id'] ?? null;
                $infinitive->verb = $request->infinitive['verb'] ?? null;
                $infinitive->pattern_verb_id = $request->infinitive['patternVerb']['id'] ?? null;
                $infinitive->hayaah = $request->infinitive['hayaah'] ?? null;
                $infinitive->pattern_hayaah_id = $request->infinitive['patternHayaah']['id'] ?? null;
                $infinitive->meme = $request->infinitive['meme'] ?? null;
                $infinitive->pattern_meme_id = $request->infinitive['patternMeme']['id'] ?? null;
                $infinitive->making = $request->infinitive['making'] ?? null;
                $infinitive->pattern_making_id = $request->infinitive['patternMaking']['id'] ?? null;
                $infinitive->inf_time = $request->infinitive['infTime'] ?? null;
                $infinitive->pattern_time_id = $request->infinitive['patternTime']['id'] ?? null;
                $infinitive->save();

                //save infinitive id to word
                $word->infinitive_id = $infinitive->id;
                
                
            }
                
            $word->save();
        
            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        
        return $word;
            
    }

    public function deleteWord($id){
        try{
            DB::beginTransaction();

            $word = Word::findOrFail($id);

            $word->removeRelations();
            $word->delete();

            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'success']);
    }

    public function getAllWordsTypes(){
        try{
            DB::beginTransaction();

            $wordTypes = WordType::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($wordTypes);
    }

    public function bulkDeleteWords(Request $request){
        Word::destroy($request->ids);

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

        $words = Word::where('text', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();
        
        return response()->json($words);
    }


    public function getAdjectiveTypePattern(){
        return response()->json(AdjectiveTypePattern::all());
    }
    public function getNounAttribution(){
        return response()->json(NounAttribution::all());
    }
    public function getNounClassPlural(){
        return response()->json(NounClassPlural::all());
    }
    public function getNounMinimize(){
        return response()->json(NounMinimize::all());
    }
    public function getNounSex(){
        return response()->json(NounSex::all());
    }
    public function getNounSexHow(){
        return response()->json(NounSexHow::all());
    }
    public function getNounType(){
        return response()->json(NounType::all());
    }
    public function getVerbPhonologicalRule(){
        return response()->json(VerbPhonologicalRule::all());
    }
    public function getVerbSyntaxicalRule(){
        return response()->json(VerbSyntaxicalRule::all());
    }
    public function getPattern(){
        return response()->json(Pattern::all());
    }

    public function getOptions(){

        $out = array(
            'pattern' => Pattern::all(),
            'adjectiveTypePattern' => AdjectiveTypePattern::all(),
            'nounAttribution' => NounAttribution::all(),   
            'nounClassPlural' => NounClassPlural::all(),
            'nounMinimize' => NounMinimize::all(),
            'nounSex' => NounSex::all(),
            'nounSexHow' => NounSexHow::all(),
            'nounType' => NounType::all(),
            'verbPhonologicalRule' => VerbPhonologicalRule::all(),
            'verbSyntaxicalRule' => VerbSyntaxicalRule::all(),
        );

        return response()->json($out);
    
    }

}
