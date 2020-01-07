<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;


class JobController extends Controller
{
    private $limit = 20;

    public function getJobs()
    {
      $jobs = Job::all();
      $jobsArr = array();
      //add actions to each job
      foreach($jobs as $job){
        $jobArr = $job->toArray();

        $jobArr['actions'] = array(
          "edit" => true,
          "delete" => !$this->hasChildOrRoot($job), //if has child or root don't allow to delete
          "view" => true
        );
        $jobArr['parent'] = Job::find($job->parent);
        $jobsArr[] = $jobArr;

      }
      return response()->json($jobsArr);
    }

    public function getOneJob($id)
    {
      $job = Job::findOrFail($id);
      $jobArr = $job->toArray();
      $jobArr['parent'] = Job::find($job->parent);
      $jobArr['actions'] = array(
        "edit" => true,
        "delete" => true,
        "view" => true
      );

      return response()->json($jobArr);
    }

    public function createJob(Request $request)
    {
      $this->validateJson($request);
      $job = $this->addOrUpdateJob($request);

      $jobArr = $job->fresh()->toArray();
      $jobArr['parent'] = Job::find($job->parent);
      $jobArr['actions'] = array(
        "edit" => true,
        "delete" => true,
        "view" => true
      );


      return response()->json($jobArr);
    }

    public function updateJob($id, Request $request)
    {
      if($id == 1){
        return response('Forbidden', 403);
      }
      $this->validateJson($request);
      $job = Job::findOrFail($id);
      $job = $this->addOrUpdateJob($request, $job);

      $jobArr = $job->fresh()->toArray();
      $jobArr['parent'] = Job::find($job->parent);
        $jobArr['actions'] = array(
            "edit" => true,
            "delete" => true,
            "view" => true
        );

      return response()->json($jobArr);
    }

    public function deleteJob($id)
    {
      $job = Job::findOrFail($id);

      if($this->hasChildOrRoot($job)){
        return response('Forbidden', 403);
      }

      Job::findOrFail($id)->delete();
      return response('Deleted Successfully', 200);
    }

    private function hasChildOrRoot($job){
      //check if node has children or is root
      if($job->parent == null){
        return true;
      }

      $countChilds = Job::where('parent', $job->id)->count();

      if($countChilds > 0){
        return true;
      }
      return false;
    }

    private function validateJson(Request $request){
      //validate Json for create/update
      $this->validate($request, [
        'name' => 'required|string',
        'parent.id' => 'required|integer',
        'user.id' => 'required|integer',
        'reviewThreshold' => 'required|integer',
        'strictDown' => 'required|boolean',
        'strictUp' => 'required|boolean',
        'displayVertical' => 'required|boolean',
        'displayOpen' => 'required|boolean'
      ]);
    }

    private function addOrUpdateJob(Request $request, Job $job = null){
      //if no job create a new one
      if(!$job){
        $job = New Job;
      }
      $job->name = $request->name;
      $job->parent = $request->parent["id"];
      $job->user_id = $request->user["id"];
      $job->review_threshold = $request->reviewThreshold;
      $job->strict_down = $request->strictDown;
      $job->strict_up = $request->strictUp;
      $job->display_vertical = $request->displayVertical;
      $job->display_open = $request->displayOpen;
      $job->save();
      return $job;

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

        $jobs = Job::where('name', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();

        return response()->json($jobs);
    }

}

