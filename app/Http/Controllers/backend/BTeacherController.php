<?php

namespace App\Http\Controllers\backend;


use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BTeacherController extends Controller
{
    //
    public function index()
    {
        $teacher = Teacher::all();
        return view('backend.teacher.index')->with('teacher', $teacher);
    }

    public function index1()
    {
        $teacher = Teacher::all();
        return view('backend.teacher.index1')->with('teacher', $teacher);
    }


    public function fetchTeacherRecord(Request $request){
        try {
            $teacher = DB::table('teachers')
                ->join('genders', 'teachers.gender_id', '=', 'genders.id') // Fixed alias mismatch
                ->select(
                    'teachers.id',
                    'teachers.teacher_code',
                    'teachers.teacher_name',
                    'teachers.teacher_dob',
                    'teachers.address',
                    'teachers.teacher_email',
                    'teachers.teacher_phone',
                    'teachers.teacher_profile',
                    'teachers.teacher_image',
                    'genders.name as gender' // Give a proper alias to avoid confusion
                )
                ->orderBy('teachers.id', 'asc') // Sort by ID
                ->get()
                ->map(function ($teacher) {
                    return [

                         'id' => $teacher->id,
                         'teacher_code' => $teacher->teacher_code,
                         'teacher_name' => $teacher->teacher_name,
                         'teacher_dob' => $teacher->teacher_dob,
                         'address' => $teacher->address,
                         'teacher_email' => $teacher->teacher_email,
                         'teacher_phone' => $teacher->teacher_phone,
                         'teacher_profile' => $teacher->teacher_profile,
                         'teacher_image' => $teacher->teacher_image ,
                         'gender' => $teacher->gender === 'Male' ? 'Male' : ($teacher->gender === 'Female' ? 'Female' : 'Other'),

                    ];
                });


            return response()->json($teacher);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch teacher records',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    public function createTeacherRecord(Request $request){
    try {
        // Validate the request
        $validatedData = $request->validate([
            'teacher_code' => 'required|string|max:100',
            'teacher_name' => 'required|string|max:50',
            'teacher_dob' => 'required|date',
            'address' => 'required|string|max:200',
            'teacher_email' => 'required|email|max:100|unique:teachers',
            'teacher_phone' => 'required|string|max:100',
            'teacher_profile' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'teacher_image' => 'nullable|string',
        ]);

          // Handle the image upload
          $teacherImagePath = null; // Default to null
        
          if (!empty($request->teacher_image)) {
              $image = $request->teacher_image;
      
              // Extract MIME type and validate format
              if (preg_match('/^data:image\/(\w+);base64,/', $image, $matches)) {
                  $extension = strtolower($matches[1]); // Extract extension
              
                  // Ensure only supported formats (png, jpg, jpeg)
                  if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
                      return response()->json(['error' => 'Invalid image format. Only PNG, JPEG, and JPG are allowed.'], 400);
                  }
              
                  // Remove base64 prefix
                  $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
                  $image = str_replace(' ', '+', $image);
              
                  // Use the original filename if provided, otherwise generate a unique name
                  $originalFilename = $request->input('filename', uniqid() . '.' . $extension);
                  
                  // Ensure the filename has the correct extension
                  $imageName = pathinfo($originalFilename, PATHINFO_FILENAME) . '.' . $extension;
              
                  // Define the correct storage path
                  $storagePath = 'teacher_images/' . $imageName;
              
                  // Store the image in storage/app/public/teacher_images/
                  Storage::disk('public')->put($storagePath, base64_decode($image));
              
                  // Save the correct path for database storage
                  $teacherImagePath = $storagePath;
              } else {
                  return response()->json(['error' => 'Invalid image data.'], 400);
              }
              
            }

        $gender = Gender::where('id', $request->gender)->first();

          if (!$gender) {
              return response()->json([
                  'success' => false,
                  'message' => 'Gender not found.',
              ], 400);
            }  

        // Save teacher record
        $teacher = Teacher::create([
            'teacher_code' => $request->teacher_code,
            'teacher_name' => $request->teacher_name,
            'teacher_dob' => $request->teacher_dob,
            'address' => $request->address,
            'teacher_email' => $request->teacher_email,
            'teacher_phone' => $request->teacher_phone,
            'teacher_profile' => $request->teacher_profile,
            'teacher_image' => $teacherImagePath,
            'gender_id' => $gender->id, // Correctly set the gender_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully!',
            'data' => $teacher,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creating teacher: ' . $e->getMessage(),
        ], 500);
    }
    }



    public function updateTeacherRecord(Request $request){
    $teacher = Teacher::find($request->id);

    if (!$teacher) {
        return response()->json([
            'success' => false,
            'message' => 'Teacher not found.',
        ], 404);
    }

    // Validate input
    try {
        $validatedData = $request->validate([
            'teacher_code' => 'sometimes|string|max:100',
            'teacher_name' => 'sometimes|string|max:50',
            'teacher_dob' => 'sometimes|date',
            'address' => 'sometimes|string|max:255',
            'teacher_email' => 'sometimes|string|max:100',
            'teacher_phone' => 'sometimes|string|max:100',
            'teacher_profile' => 'sometimes|string|max:255',
            'gender_id' => 'sometimes|integer',
        ]);

        // Handle image update
        if ($request->filled('teacher_image')) {
            $image = $request->teacher_image;
        
            if (preg_match('/^data:image\/(\w+);base64,/', $image, $matches)) {
                $extension = strtolower($matches[1]);
        
                if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
                    return response()->json(['error' => 'Invalid image format. Only PNG, JPEG, and JPG are allowed.'], 400);
                }
        
                // Remove base64 prefix
                $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
                $image = str_replace(' ', '+', $image);
        
                // Get original filename from request
                $originalFilename = $request->input('filename', null);
        
                if ($originalFilename) {
                    // Extract the filename without extension
                    $fileBaseName = pathinfo($originalFilename, PATHINFO_FILENAME);
                    // Ensure the filename has the correct extension
                    $imageName = $fileBaseName . '.' . $extension;
                } else {
                    // If no filename is provided, generate a unique one
                    $imageName = uniqid('teacher_', true) . '.' . $extension;
                }
        
                $storagePath = 'teacher_images/' . $imageName;
        
                // Store the image in storage/app/public/teacher_images/
                Storage::disk('public')->put($storagePath, base64_decode($image));
        
                // Delete old image if it exists
                if ($teacher->teacher_image) {
                    Storage::disk('public')->delete($teacher->teacher_image);
                }
        
                // Update the teacher's image path
                $teacher->teacher_image = $storagePath;
                } else {
                    return response()->json(['error' => 'Invalid image data.'], 400);
                }
        }
        

        // Update teacher record (only fields that are present in the request)
        $teacher->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Teacher record updated successfully!',
            'data' => $teacher,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating teacher: ' . $e->getMessage(),
        ], 500);
    }
}



public function deleteTeacherRecord($id){
    
    try {
        // Find the teacher by ID
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }

        // Delete the teacher's profile image if it exists
        if ($teacher->teacher_image && Storage::disk('public')->exists($teacher->teacher_image)) {
            Storage::disk('public')->delete($teacher->teacher_image);
        }

        // Delete the teacher record
        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully!',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting teacher: ' . $e->getMessage(),
        ], 500);
    }
}
    



}
