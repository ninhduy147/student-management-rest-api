<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $students = Student::with('classes:id,class_name')->get();
            return StudentResource::collection($students);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách sinh viên',
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            $student = Student::create($data);

            if ($request->has('class_ids')) {
                $student->classes()->attach($request->input('class_ids'));
            }

            return response()->json([
                'status'  => 201,
                'message' => 'Tạo học sinh thành công',
                'data'    => $student->load('classes')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Có lỗi xảy ra khi tạo học sinh',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $class = Student::select('id','user_id','student_code','full_name','birthday','gender','class_id')->findOrFail($id);
            $updatedStudent = Student::with('classes')->find($id);
            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin hoc sinh thành công',
                'data' => $updatedStudent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hoc sinh ',
                // 'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $student = Student::where('id', $id)->first();

            if (!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy học sinh!'
                ]);
            }

            $data = $request->validated();
            $student->update($data);

            if ($request->has('class_ids')) {
                $student->classes()->sync($request->input('class_ids'));
            }

            $updatedStudent = Student::with('classes')->find($id);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công',
                'data' => $updatedStudent
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi cập nhật học sinh',
                'error' => $e->getMessage()
            ]);
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
           $student = Student::where('id',$id)->whereNull('deleted_at')->first();
            if(!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Học sinh không tồn tại hoặc đã bị xóa!'
                ]);
            }
            $student->delete();

             return response()->json([
                'status' => 200,
                'message' => 'Xóa thành công',
            ]);
        } catch (\Exception $e) {
           return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra',
                'error' => $e->getMessage()
            ]);
        }
    }
}
