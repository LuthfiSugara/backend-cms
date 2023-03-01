<?php

namespace App\Repositories\Api;

use App\Models\Post;
use App\Models\User;

class PostRepository {
    public function index($data){
        try{
            $limit = 15;
            if($data->limit){
                $limit = $data->limit;
            }

            $post = new Post;
            $post = $post->with(['creator', 'category']);

            if($data->search){
                $post->where('title', 'like', '%'.$data->search.'%');
            }

            $post = $post->orderBy('created_at', 'desc');
            $post = $post->paginate($limit)->onEachSide(1)->toArray();

            $metadata = [
                'current_page' => $post['current_page'],
                'last_page' => $post['last_page'],
                'per_page' => $post['per_page'],
                'total' => $post['total'] * $post['last_page'],
            ];

            if($post){
                return response()->json([
                    'status' => 'success',
                    'metadata' => $metadata,
                    'data' => $post['data'],
                    'message' => 'success'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Data tidak ditemukan!'
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
            $create = new Post;
            $create->title = $data->title;
            $create->id_creator = auth('sanctum')->user()->id;
            $create->id_category = $data->id_category;
            $create->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data->title)));
            $create->content = $data->content;
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
            $detail = Post::where('id', $id)->with(['creator', 'category'])->first();
            $user = User::where('id', auth('sanctum')->user()->id)->first();

            if($detail->id_creator != auth('sanctum')->user()->id || $user->hasAnyRole(['admin', 'editor'])){
                return response()->json([
                    'status' => 403,
                    'message' => 'You do not have access to this permission'
                ], 403);
            }

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
            $user = User::where('id', auth('sanctum')->user()->id)->first();
            $update = Post::find($data->id);
            
            if($update->id_creator != auth('sanctum')->user()->id || $user->hasAnyRole(['admin', 'editor'])){
                return response()->json([
                    'status' => 403,
                    'message' => 'You do not have access to this permission'
                ], 403);
            }

            $update->title = $data->title;
            $update->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data->title)));
            $update->id_category = $data->id_category;
            $update->content = $data->content;
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
            $user = User::where('id', auth('sanctum')->user()->id)->first();
            $detail = Post::where('id', $id)->with(['creator', 'category'])->first();

            if($detail->id_creator != auth('sanctum')->user()->id || $user->hasAnyRole(['admin', 'editor'])){
                return response()->json([
                    'status' => 403,
                    'message' => 'You do not have access to this permission'
                ], 403);
            }

            $delete = Post::find($id)->delete();

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