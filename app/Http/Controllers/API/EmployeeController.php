<?php

namespace App\Http\Controllers\API;

use App\Model\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function getAllEmployee()
    {
        $result = Employee::paginate(10);
        if (count($result) > 0) return response()->json(['status' => 'OK', 'data' => $result], 200);
        return response()->json(['status' => 'NG', 'message' => 'Data does not exist!'], 200);
    }

    public function save(Request $request)
    {
        $result = Employee::insert([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'english_skill' => $request->english_skill,
            'japanese_skill' => $request->japanese_skill,
        ]);
        if ($result)    return response()->json(['status' => 'OK', 'message' => 'Data was created successfully!'], 200);
        return response()->json(['status' => 'NG', 'message' => 'Create Failed!'], 200);
    }

    public function show($id)
    {
        $result = Employee::where('id', $id)->first();
        Log::info($result);
        if (!empty($result))  return response()->json(['status' => 'OK', 'data' => $result], 200);
        return response()->json(['status' => 'NG', 'message' => 'Data does not exist!'], 200);
    }

    public function update(Request $request, $id)
    {
        $result = Employee::where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'english_skill' => $request->english_skill,
                'japanese_skill' => $request->japanese_skill,
            ]);
        if ($result)  return response()->json(['status' => 'OK', 'message' => 'Data was updated successfully!'], 200);
        return response()->json(['status' => 'NG', 'message' => 'Update Failed!'], 200);
    }

    public function delete($id)
    {
        $result = Employee::where('id',$id)->delete();
        if ($result)    return response()->json(['status' => 'OK', 'message' => 'Data was deleted successfully!']);;
        return response()->json(['status' => 'NG', 'message' => 'Delete Failed!'], 200);
    }

    public function search(Request $request)
    {
        $query = new Employee;
        if($request->name != null) $query = $query->where('name',$request->name);
        if($request->gender != null) $query = $query->where('gender',$request->gender);
        
        $result = $query->paginate(10);
        if (count($result) > 0) return response()->json(['status' => 'OK', 'data' => $result], 200);
        return response()->json(['status' => 'NG', 'message' => 'Data does not exist!'], 200);
    }
}