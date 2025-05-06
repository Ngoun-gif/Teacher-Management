<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = course::all();
        return view('backend.setting.course.index')->with('courses',$courses);
    }

    public function fetchCourseRecord(Request $request){

        $data = DB::table('courses')
                    ->select('id'
                    ,'course_code'
                    ,'course_name'
                    ,'duration'
                    ,'course_price')
                    ->orderBy('courses.id', 'asc') // Sort by ID
                    ->get();
        return response()->json($data);
    }

    public function createCourseRecord(Request $request){

        $courses = DB::table('courses')->insert([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,

            'duration' => $request->duration,
            'course_price' => $request->price,
        ]);
        return response()->json(['success' => true, 'message' => 'Course created successfully']);

    }
    public function updateCourseRecord(Request $request){
        // Validate the request data
        $request->validate([
            'id' => 'required|integer', // Ensure the ID is provided
            'course_name' => 'string|max:100',

            'duration' => 'numeric',
            'course_price' => 'numeric',
        ]);
        try {

            $updated = DB::table('courses')
                ->where('id', $request->id)
                ->update([
                    'course_name' => $request->course_name,

                    'duration' => $request->duration,
                    'course_price' => $request->price, // Ensure this matches the database column name
                ]);

            // Check if any rows were updated
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course updated successfully.',
                ]);
            }
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error updating course: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCourseRecord($id){

        try{
            $course = DB::table('courses')->where('id', $id)->first();
            if ($course) {
                // Delete the course
                DB::table('courses')->where('id', $id)->delete();

                return response()->json(['message' => 'Course deleted successfully'], 200);

            } else {

                return response()->json(['message' => 'Course not found'], 404);
            }

            } catch (\Exception $e){

                return response()->json(['message' => 'Error deleting course: ' . $e->getMessage()], 500);
            }

    }




}
