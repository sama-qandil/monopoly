<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$type)
    {
        $type=match($type){
            'daily'=>'daily',
            'weekly'=>'weekly',
            'champion'=>'champion',
            default=> null,
        };

        $tasks=Task::where('type',$type)->with(['users' =>function($query) use ($request){
            $query->where('user_id',$request->user()->id);
        }])->get();
        return $this->success(TaskResource::collection($tasks),"Tasks retrieved successfully");
    }

    
    public function collect(Request $request , $taskId){
        $user=$request->user();

        $task = Task::with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->findOrFail($taskId);

        $userProgress=$task->users->first();

        if(!$userProgress || !$userProgress->pivot->is_completed || !$userProgress->pivot->is_collected){
            return $this->error(null,'cannot collect reward for this task');
        }

      
        DB::transaction(function () use ($user, $task) {
           
            $user->increment('gold', $task->reward_gold);
            $user->increment('gems', $task->reward_gems);
            $user->increment('current_experience', $task->reward_points);

         
            $user->tasks()->updateExistingPivot($task->id, [
                'is_collected' => true
            ]);
        });

        return $this->success(null, 'Reward collected successfully');
    }
        
    
    

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
