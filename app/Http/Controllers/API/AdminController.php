<?php

namespace App\Http\Controllers\API;

use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getAllAdmin()
    {
        $result = Admin::paginate(10);
        if (count($result) > 0) return response()->json(['status' => 'OK', 'data' => $result], 200);
        return response()->json(['status' => 'NG', 'message' => 'Data does not exist!'], 200);
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $userCode = DB::table('admins')->latest()->value('user_code');
        if($userCode != null){
            $userCode = $userCode + 1;
        }else{
            $userCode = 20001;
        }
        
        $name = $request->name;
        $password = $request->password;
        $result = Admin::insert([
            'user_code' => $userCode,
            'name' => $name,
            'password' => $password,
        ]);
        if ($result)    return response()->json(['status' => 'OK', 'message' => 'Data was created successfully!'], 200);
        return response()->json(['status' => 'NG', 'message' => 'Create Failed!'], 200);
    }

    public function show($id)
    {
        $result = Admin::where('id', $id)->first();
        if (!empty($result))  return response()->json(['status' => 'OK', 'data' => $result], 200);
        return response()->json(['status' => 'NG', 'message' => 'Data does not exist!'], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => "required|unique:admins,name," . $id . ",id,deleted_at,NULL|max:255",
            'password' => 'required',
        ]);
        $result = Admin::where('id', $id)
            ->update([
                'name' => $request->name,
                'password' => $request->password
            ]);
        if ($result)  return response()->json(['status' => 'OK', 'message' => 'Data was updated successfully!'], 200);
        return response()->json(['status' => 'NG', 'message' => 'Update Failed!'], 200);
    }

    public function delete($id)
    {
        $result = Admin::where('id',$id)->delete();
        if ($result)    return response()->json(['status' => 'OK', 'message' => 'Data was deleted successfully!']);;
        return response()->json(['status' => 'NG', 'message' => 'Delete Failed!'], 200);
    }

    public function login(Request $request)
    {
        $admin = Admin::where('user_code',$request->user_code)->first();
        if($admin != null){
            if($request->password != $admin->password){
                return response()->json(['status' => 'NG', 'message' => 'Incorrect Password!'], 200);
            }
            return response()->json(['status' => 'OK', 'message' => 'Login successfully!'], 200);
        }else{
            return  response()->json(['status' => 'NG', 'message' => 'Admin does not exists!'], 200);
        }
    }
}
