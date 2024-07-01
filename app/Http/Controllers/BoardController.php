<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardController extends Controller
{

    /**
     * Retrieve information of boards of the authenticated user
    */
    public function index(){
        try{
            $boards = auth()->user()->boards()->get();
            return response()->json([
                'success' => true,
                'data' => $boards,
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retriving board: ' . $e->getMessage(),
            ], 500);    
        }
    }
    /**
     * Store a newly created board
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:400',
            'description' => 'nullable|string',
        ]);
        try {
            $board = auth()->user()->boards()->create($data);
            return response()->json([
                'success' => true,
                'message'=> 'Board created Successfully',
                'data' => $board,
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while craeting board: ' . $e->getMessage(),
            ], 500);    
        }
    }

    /**
     * Update a specific baord
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'description' => 'nullable|string'
        ];
        if($request->filled('name')){
            $rules['name'] = 'required|string|max:400';
        }
        $data = $request->validate($rules);
        try {
            $board = auth()->user()->boards()->findOrFail($id);
            $board->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Baord updated successfully',
                'data' => $board,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Board not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update board: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a board
     */
    public function destroy($id)
    {
        try{
            $board = auth()->user()->boards()->findOrFail($id);
            $board->delete();
            return response()->json([
                'success' => true,
                'message' => 'Baord deleted successfully',
                'data' => $board,
            ], 200);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Board not exist',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete board: ' . $e->getMessage(),
            ], 500);
        }
    }
}
