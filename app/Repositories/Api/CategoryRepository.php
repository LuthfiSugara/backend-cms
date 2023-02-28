<?php

namespace App\Repositories\Api;

use App\Models\Category;

class CategoryRepository {
    public function index($data){
        try{
            $category = Category::orderBy('name', 'asc')->get();

            if($category){
                return response()->json([
                    'status' => 'success',
                    'data' => $category,
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong!'
                ], 404);
            }

        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function store($data){
        try{
            $create = new Category;
            $create->name = $data->name;
            $create->created_at = round(microtime(true));
            $create->updated_at = round(microtime(true));
            $create->save();

            if($create){
                return response()->json([
                    'status' => 'success',
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong!'
                ], 404);
            }

        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function show($id){
        try{
            $detail = Category::where('id', $id)->first();

            if($detail){
                return response()->json([
                    'status' => 'success',
                    'data' => $detail,
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong!'
                ], 404);
            }

        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function update($data){
        try{
            $update = Category::where('id', $data->id)->first();
            $update->name = $data->name;
            $update->updated_at = round(microtime(true));
            $update->save();

            if($update){
                return response()->json([
                    'status' => 'success',
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong!'
                ], 404);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function destroy($id){
        try{
            $delete = Category::find($id)->delete();

            if($delete){
                return response()->json([
                    'status' => 'success',
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong!'
                ], 404);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 403);
        }
    }
}