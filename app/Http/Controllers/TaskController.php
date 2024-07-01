<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display list of the tasks.
     */
    public function index(Board $board)
    {
        try{
            $tasks = $board->tasks;
            return response()->json([
                'success' => true,
                'data' => $tasks,
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to get task',
            ], 500);
        }
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request, Board $board)
    {
        try{
            $data = $request->validate([
                'title' => 'required|string|max:400',
                'description' => 'nullable|string',
            ]);
            $task = $board->tasks()->create($data);
            if($task){
                return response()->json([
                    'success' => true,
                    'message'=> 'Task created Successfully',
                    'data' => $task,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create task',
                ], 500);
            }
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while craeting task: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific task of a board
     */
    public function show($boardId, Task $task)
    {
        // check if the task belong to the board
        if($task->board_id == $boardId){
            return response()->json([
                'success' => true,
                'data' => $task,
            ],200);
        }
        return response()->json([
            'message' => 'The task doesn\'t belong to the board',
            'success' => false,
        ],400);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $boardId, Task $task)
    {
        try{
            $rules = [
                'description' => 'nullable|string',
            ];
            if($request->filled('title')){
                $rules['title'] = 'required|string|max:400';
            }
            $data = $request->validate($rules);
            if($task->board_id == $boardId){
                $task->update($data);
                return response()->json([
                    'message' => 'Task Updated successfully',
                    'data' => $task
                ],200);    
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Unable to update' . $e->getMessage(),
                'success' => false,
            ],500);    
        }
    }

    /**
     * delete a specific task
     */
    public function destroy($boardId, Task $task)
    {
        try{
            if($task->board_id == $boardId){
                $task->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'task deleted',
                    'data' => $task,
                ], 200);    
            }
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task: ' . $e->getMessage(),
            ], 500);
        }
    }
}
