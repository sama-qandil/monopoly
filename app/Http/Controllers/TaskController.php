<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type)
    {

        $tasks = $request->user()->tasks()
        ->where('tasks.type', $type) // TODO: better use ->where('type', $type), no need for tasks.type
        ->get();
        return $this->success(TaskResource::collection($tasks),"Tasks retrieved successfully");
    }

    
    public function collect(Request $request , $taskId){
       $user = $request->user();

       $task = $user->tasks()->where('tasks.id', $taskId)->firstOrFail();

        $progress = $task->pivot;

        if(!$progress || !$progress->is_completed || $progress->is_collected){
            return $this->error('cannot collect reward for this task', 400);
        }

        DB::transaction(function () use ($user, $task) {

            $user->increment('gold', $task->reward_gold);
            $user->increment('gems', $task->reward_gems);
            $user->increment('current_experience', $task->reward_points); // TODO: handle level up logic

            $user->tasks()->updateExistingPivot($task->id, [
                'is_collected' => true,
            ]);
        });

        return $this->success('Reward collected successfully',200);
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
