<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use DB;

class EmployeeController extends Controller
{
    public function index(){

        return view('pages.employee.index',[
            'title' => 'Employee List',
            'employees' => Employee::where('is_deleted', 0)->get(),
        ]);
    }

    public function create(Request $req){
        if($req->id){
            return view('pages.employee.create',[
                'title' => 'Edit Employee',
            ]);
        } else {
            return view('pages.employee.create',[
                'title' => 'Add Employee',
            ]);
        }
    }

    public function save(Request $req){
        // dd($req->toArray());
        if($req->id){
            DB::beginTransaction();
            try{

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Employee Updated Successfully'
            ]);
            } catch (\Exception $e){
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'msg' => $e->getMessage(),
                ]);
            }
        } else {
            DB::beginTransaction();
            try{
                $employee = new Employee();
                $employee->name = $req->name;
                $employee->email = $req->email;
                $employee->phone_number = $req->phone_no;
                $employee->date_of_birth = $req->dob;
                $employee->address = $req->address;

                if($req->hasFile('image')){
                    $file = $req->file('image');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('uploads/employees'), $filename);
                    $employee->image_url = 'uploads/employees/'.$filename;
                }
                $employee->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'Employees Saved Successfully'
            ]);
            } catch (\Exception $e){
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'msg' => $e->getMessage(),
                ]);
            }
        }
    }

    public function delete(Request $req){
        DB::beginTransaction();
        try{
            $employee = Employee::find($req->id);
            $employee->is_deleted = 1;
            $employee->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Employee Deleted Successfully'
            ]);
        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
    
}
