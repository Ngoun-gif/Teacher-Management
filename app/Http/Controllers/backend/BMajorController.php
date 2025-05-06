<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BMajorController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        {
            $major = Major::all();
            return view('backend.setting.major.index')->with('majors',$major);
        }

    }
    public function fetchMajorRecord(Request $request){


        $major = Major::all()->map(function ($major) {
            return [
                'id' => $major->id,
                'major_type' => $major->major_type,
                'description' => $major->description,
                'state' => $major->state ? '1' : '0',
                // 'state' => $major->state ? '1🟢' : 'Inactive🔴',
            ];
        });

        return response()->json($major);

    }

    public function createMajorRecord(Request $request) {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'major_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'state' => 'required|in:1,0',  // Ensures 'state' is either 0 or 1
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            // Insert data using Eloquent
            $major = Major::create([
                'major_type' => $request->major_type,
                'description' => $request->description,
                'state' => (string) $request->state, // Convert to string to match ENUM
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Major created successfully',
                'data' => $major, // Return the created record
            ], 201);

        } catch (\Exception $e) {
            // Handle errors and exceptions
            return response()->json([
                'success' => false,
                'message' => 'Error creating major: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateMajorRecord(Request $request){

        $request->validate([
            'id' => 'required|integer', // Ensure the ID is provided
            'major_type' => 'string|max:50',
            'description' => 'string|max:200',
            'state' => 'required|integer|in:0,1', // Ensuring state is either 0 or 1
        ]);

        try {
            // Find the Major by ID
            $major = Major::find($request->id);

            // Check if Major exists
            if (!$major) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found.',
                ], 404);
            }

            // Update the record
            $major->update([
                'major_type' => $request->major_type,
                'description' => $request->description,
                'state' => $request->state, // Directly update, no need for DB::raw
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error updating course: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteMajorRecord($id){

        try{
            $major = Major::find($id);
            if(!$major){
                return response()->json([
                    'success' => false,
                    'message' => 'Major not found.',
                ], 404);
            }
            $major->delete();
            return response()->json([
                'success' => true,
                'message' => 'Major deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting major: ' . $e->getMessage(),
            ], 500);
        }

    }
}
