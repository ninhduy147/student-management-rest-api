<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\UpdateClassesRequest;
use Illuminate\Container\Attributes\Log;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Classes::all();
        try {
            $classes = Classes::select('id','class_code','class_name')
            ->get();
            return response()->json([
                'status' => 200,
                'message' => 'Lấy danh sách thành công',
                'data' => $classes
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
    public function store(StoreClassesRequest $request)
    {
        try {
            $data = $request->validated();
            $class = Classes::create($data);
            return response()->json([
                'status'  => 201,
                'message' => 'Tạo lớp thành công',
                'data'    => $class
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Có lỗi xảy ra khi tạo lớp',
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
            $class = Classes::select('id','class_code','class_name')->findOrFail($id);

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin lớp thành công',
                'data' => $class
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy lớp học',
                // 'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassesRequest $request, $id)
    {
        try {
            $class = Classes::where('id',$id)->whereNull('deleted_at')->first();
            if(!$class) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy lớp học!'
                ]);
            }

            $data = $request->validated();
            $class->update($data);

            return response()->json([
                'status' => 200,
                'message' => 'Sửa thành công',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra',
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
           $class = Classes::where('id',$id)->whereNull('deleted_at')->first();
            if(!$class) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Lớp học không tồn tại hoặc đã bị xóa!'
                ]);
            }
            $class->delete();

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
