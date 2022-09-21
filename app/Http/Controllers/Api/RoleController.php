<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RoleController extends BaseController
{

    public function allRole(){
        $roleArr= DB::Table('role_tbl')->get();
        return response()->json($roleArr);
    }
    // ----------------------------------------
    public function editRole(Request $request)
    {
        $idRole = $request->idRole;
        $roleName= $request->roleName;
        $validate = BaseController::SQLValidate($idRole);
        $validate1 = BaseController::SQLValidate($roleName);
        $validate2=  BaseController::checkInt($idRole);
        if($validate2==false||$validate==false||$validate1==false){
            return response()->json(['status'=>400]);
        }else{
            $column='roleName';
            $table='role_tbl';
            $exist= BaseController::checkExist($roleName,$table,$column);
            if($exist==0){
                DB::Table('role_tbl')->where('id',$idRole)->update(['roleName'=>$roleName,'updated_at'=>now()]);
                return response()->json(['status'=>200]);
            }else{
                return response()->json(['status'=>400]);
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request)
    {
        $roleName = $request->roleName;
        $check = BaseController::SQLValidate($roleName);
        if($check == false){
            return response()->json(['status'=>400]);
        }else{
            $column='roleName';
            $table='role_tbl';
            $exist= BaseController::checkExist($roleName,$table,$column);
            if($exist==0){
                DB::Table('role_tbl')->insert(['roleName'=> $roleName,'created_at'=>now()]);
                return response()->json(['status'=>200]);
            }else{
                return response()->json(['status'=>401,'message'=>'Exist']);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteRole(Request $request)
    {
        $idRole = $request->idRole;
        $table = 'users';
        $column='idRole';
        $validate=  BaseController::checkInt($idRole);
        $validate2=  BaseController::checkExist($idRole,$table,$column);
        if($validate==false||$validate2!=0){
            return response()->json(['status'=>400]);
        }else{
            DB::Table('role_tbl')->where('id',$idRole)->delete();
            return response()->json(['status'=>200]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
