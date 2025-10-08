<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Resources\GradeResource;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['enrollment.student', 'enrollment.subject'])->get();
        return GradeResource::collection($grades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        try {
            $data = $request->validated();
            // $data['teacher_id'] = auth()->id();
            $grade = Grade::create($data);

            return response()->json([
            'status'  => 201,
            'message' => 'Tạo điểm thành công',
            'data'    => $grade
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 500,
            'message' => 'Có lỗi xảy ra khi tạo điểm',
            'error'   => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $grade = Grade::with(['enrollment.student', 'enrollment.subject'])->findOrFail($id);
        return new GradeResource($grade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, $id)
    {
        try {
                $grade = Grade::find($id);
                if (!$grade) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Không tìm thấy điểm!',
                    ]);
                }

                $data = $request->validated();
                $grade->update($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật thành công',
                    'data' => $data,
                ]);

            } catch (\Throwable $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Có lỗi xảy ra khi cập nhật điểm',
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
           $grade = Grade::where('id',$id)->first();
            if(!$grade) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Điểm không tồn tại hoặc đã bị xóa!'
                ]);
            }
            $grade->delete();

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
