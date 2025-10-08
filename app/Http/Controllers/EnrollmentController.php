<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Danh sách đăng ký
     */
    public function index()
    {
        try {
            $enrollments = Enrollment::with(['student', 'subject'])
                ->select('id', 'student_id', 'subject_id', 'created_at')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Lấy danh sách đăng ký môn học thành công',
                'data' => EnrollmentResource::collection($enrollments),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi lấy danh sách đăng ký',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sinh viên đăng ký môn học
     */
    public function store(StoreEnrollmentRequest $request)
    {
        try {
            $data = $request->validated();

            if (auth()->user()->role === 'student') {
                $student = Student::where('user_id', auth()->id())->first();

                if (!$student) {
                    return response()->json([
                        'status'  => 404,
                        'message' => 'Không tìm thấy thông tin sinh viên cho tài khoản này'
                    ], 404);
                }

                $data['student_id'] = $student->id;
            }

            $enrollment = Enrollment::create($data);

            return response()->json([
                'status'  => 201,
                'message' => 'Đăng ký môn học thành công',
                'data'    => $enrollment
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Có lỗi xảy ra khi đăng ký',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị chi tiết enrollment
     */
    public function show($id)
    {
        try {
            $enrollment = Enrollment::with([
            'student:id,full_name',
            'subject:id,subject_name'
            ])->findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin hoc sinh thành công',
                'data' => new EnrollmentResource($enrollment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy ',
                // 'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Cập nhật enrollment
     */
    public function update(UpdateEnrollmentRequest $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($request->validated());

        return response()->json([
            'status'  => 200,
            'message' => 'Cập nhật đăng ký thành công',
            'data'    => new EnrollmentResource($enrollment->load(['student', 'subject']))
        ]);
    }


    /**
     * Hủy đăng ký môn học
     */
    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy đăng ký này!'
            ]);
        }

        $enrollment->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Hủy đăng ký thành công'
        ]);
    }
}
