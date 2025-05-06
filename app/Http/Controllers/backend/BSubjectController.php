<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subject = Subject::all();
        return view('backend.setting.subject.index')->with('subjects',$subject);
    }

    public function fetchSubjectRecord(Request $request){
    try {
        $data = DB::table('subjects')
            ->select('id', 'subject_name', 'description')
            ->get();

        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch subject records',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function createSubjectRecord(Request $request) {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:50',
            'description' => 'nullable|string',
            
        ]);
    
        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    
        try {
            // Insert data using Eloquent
            $subject = Subject::create([
                'subject_name' => $request->subject_name,
                'description' => $request->description,
               
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Subject created successfully',
                'data' => $subject, // Return the created record
            ], 201);
    
        } catch (\Exception $e) {
            // Handle errors and exceptions
            return response()->json([
                'success' => false,
                'message' => 'Error creating subject: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateSubjectRecord(Request $request){
        

        
        $request->validate([
            'id' => 'required|integer', // Ensure the ID is provided
            'subject_name' => 'string|max:50',
            'description' => 'string|max:200',
           
        ]);
        
        try {
            // Find the Major by ID
            $subject = Subject::find($request->id);
    
            // Check if Major exists
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found.',
                ], 404);
            }
    
            // Update the record
            $subject->update([
                'subject_name' => $request->subject_name,
                'description' => $request->description,
               
            ]);
    
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Subject updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error updating subject: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteSubjectRecord($id){
        // Find the Major
        $subject = Subject::find($id);
    
        // Check if Major exists
        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Subject not found.',
            ], 404);
        }
    
        // Delete the Major
        $subject->delete();
    
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Subject deleted successfully.',
        ]);
    }
   
    
}
