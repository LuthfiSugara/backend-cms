<?php

namespace App\Repositories\Api;

use App\Models\User;

class UserRepository {
    public function index($data){
        try{
            $limit = 15;
            if($data->limit){
                $limit = $data->limit;
            }

            $user = new User;
            $user = $user->with(['role']);

            if($data->search){
                $user->where('name', 'like', '%'.$data->search.'%');
            }

            $user = $user->orderBy('created_at', 'desc');
            $user = $user->paginate($limit)->onEachSide(1)->toArray();

            $metadata = [
                'current_page' => $user['current_page'],
                'last_page' => $user['last_page'],
                'per_page' => $user['per_page'],
                'total' => $user['total'] * $user['last_page'],
            ];

            if($user){
                return response()->json([
                    'status' => 'success',
                    'metadata' => $metadata,
                    'data' => $user['data'],
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
            $create = new User;
            $create->name = $data->name;
            $create->email = $data->email;
            $create->password = bcrypt($data->password);
            $create->id_role = $data->id_role;
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
            $detail = User::where('id', $id)->with(['role'])->first();

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
            $update = User::find($data->id)->first();
            $update->name = $data->name;

            if($data->password){
                $update->password = bcrypt($data->password);
            }

            $update->id_role = $data->id_role;
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
            $delete = User::find($id)->delete();

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