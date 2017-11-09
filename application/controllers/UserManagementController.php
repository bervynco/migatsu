<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Users;
class UserManagementController extends Controller
{
    public function getUserList(){
        $users = Users::get(['id', 'name', 'username', 'role', 'created_at', 'updated_at']);
        echo json_encode($users);

    }

    public function addNewUser(Request $request){
        $users = $request->all();
        
        // $userModel = Users::create($users);
        $userModel = Users::create([
            'name' => $users['name'],
            'username' => $users['username'],
            'password' => bcrypt($users['password']),
            'role' => $users['role']
        ]);
        if(!$userModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function changePassword(Request $request){
        $userData = $request->all();
        
        $userModel = Users::find($request->id);

        $userModel['password'] = $userData['password'];

        if(!$userModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }
    public function editUser(Request $request){
        $userData = $request->all();
        $userModel = Users::find($request->id);
        $userModel['username'] = $userData['username'];
        $userModel['role'] = $userData['role'];

        if(!$userModel->save()){
            Log::abort(500, 'Error');
        }
        else{
            return Response::json(array('success' => true, 'message' => "Successfully edit data to DB."), 200);
        }
    }

    public function deleteUser(Request $request){
        $deletedRows = Users::where('id', $request->id)->delete();

        if($deletedRows == 1){
            return "Successful";
        }
        else{
            return "Error";
        }
        echo json_encode($deletedRows);

    }
}
