<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subjects = Subject::select('id', 'teacher_id', 'subject_code', 'subject_name')
            ->whereHas('users', function ($query) {
                $query->where('role', 'teacher');
            })
            ->with('users')
            ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Lấy danh sách thành công',
                'data' => $subjects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Có lỗi xảy ra',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        try {
            $data = $request->validated();
            $data['teacher_id'] = auth()->id();
            $subject = Subject::create($data);

            return response()->json([
                'status'  => 201,
                'message' => 'Tạo môn học thành công',
                'data'    => $subject
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
            $subject = Subject::select('id', 'teacher_id', 'subject_code', 'subject_name')->findOrFail($id);
            $updatedSubject = Subject::with('users')->find($id);
            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin môn học thành công',
                'data' => $updatedSubject
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy môn học ',
                // 'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, $id)
    {
        try {
            $subject = Subject::find($id);

            if (!$subject) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy môn học!',
                ]);
            }

            $data = $request->validated();
            $subject->update($data);

            $updatedSubject = Subject::with('users')->find($id);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công',
                'data' => $updatedSubject,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi cập nhật môn học',
                'error' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       try {
           $subject = Subject::where('id',$id)->first();
            if(!$subject) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Môn học không tồn tại hoặc đã bị xóa!'
                ]);
            }
            $subject->delete();

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
