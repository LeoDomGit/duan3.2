<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allUsers()
    {
        $result= DB::Table('users')->join('role_tbl','users.idRole','=','role_tbl.id')->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $username = $request->username;
        $email = $request->email;
        $roleid = $request->roleId;
        $validateMail =BaseController::checkMail($email);
        if(BaseController::checkNull($username)==false||BaseController::checkNull($email)==false||BaseController::checkNull($roleid)==false){
            return response()->json(['status'=>401,'eror'=>'missing']);
        }else if(BaseController::checkInt($roleid)==true&&BaseController::SQLValidate($email)==true&&BaseController::SQLValidate($username)==true&&$validateMail==true){
                 $check = BaseController::checkExist($email,'users','email');
            if($check!=0){
                return response()->json(['status'=>401,'eror'=>'exist']);
            }else{
                if(BaseController::checkExist($roleid,'role_tbl','id')==0){
                    return response()->json(['status'=>401,'eror'=>'wrongvalue']);
                }else{
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $password = substr(str_shuffle($permitted_chars), 0, 10);
                    $pass1= Hash::make($password);
                    DB::Table('users')->insert(['username'=>$username,'password'=>$pass1,'idRole'=>$roleid,'email'=>$email,'created_at'=>now()]);
                    $details = [
                        'title' => 'Email thông báo tài khoản',
                        'username'=> $username,
                        'password'=> $password,
                        'time'=>'Tài khoản được tạo vào lúc: '.date('d/m/yy',time()),
                        'thongbao'=>'Vui lòng đăng nhập và thay đổi mật khẩu . '
                    ];
                    Mail::to($email)->send(new \App\Mail\EmailThongBao($details));
                    return response()->json(['status'=>200]);
                }
            }
        }else{
            return response()->json(['status'=>401,'eror'=>'sqlmistake']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function checkEmail(){
        $email = trim($_GET['email']);
        if(BaseController::SQLValidate($email)==true&&BaseController::checkMail($email)==true){
            $check = BaseController::checkExist($email,'users','email');
            if($check==0){
                return response()->json(['check'=>false]);
            }else{
                return response()->json(['check'=>true]);
            }
        }else{
            return response()->json(['check'=>false]);

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
