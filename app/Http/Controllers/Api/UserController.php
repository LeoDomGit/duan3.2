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

    // ===============================
    public function getTeamLeads(){
        $idRole = DB::table('role_tbl')
        ->where('roleName', 'like', 'Team Leader')
        ->get();
        $teamlead = DB::Table('users')->join('user_role','users.id','=','user_role.idRole')->join('role_tbl','user_role.idRole','=','role_tbl.idRole')->where('role_tbl.roleName','like','Team%leader')->select('id as idUser','username','roleName','email','users.created_at')->get();
        return response()->json($teamlead);
    }

    /**
     * Display a listing of the resource.

     **/
    public function blockUser(Request $request){
        $username = $request->username;
        $check = BaseController::SQLValidate($username);
        $idUser = BaseController::getValue('users',$username,'username','id');
        $oldStatus = BaseController::getValue('users',$username,'username','status');
        if($oldStatus==1){
            DB::table('user_role')->where('idUser',$idUser)->update(['status'=>0,'updated_at'=>now()]);
        }else{
            DB::table('user_role')->where('idUser',$idUser)->update(['status'=>1,'updated_at'=>now()]);
        }

    }
    // =======================================
    function updateRole(Request $request){
        $username = $request->username;
        $check = BaseController::SQLValidate($username);
        $idRole = $request->idRole;
        $check2 =BaseController::checkInt($idRole);
        if($check2==true&&$check==true){

        $idUser = BaseController::getValue('users',$username,'username','id');
        DB::table('user_role')->where('idUser',$idUser)->update(['idRole'=>$idRole,'updated_at'=>now()]);
        return response()->json(['status' =>200]);
    }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allUsers()
    {
        $result= DB::Table('users')->join('user_role','users.id','=','user_role.idUser')->join('role_tbl','user_role.idRole','=','role_tbl.idRole')->select('*','user_role.idRole as userRoleID')->get();
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
        $validateMail =BaseController::checkMail($email);
        if(BaseController::checkNull($username)==false||BaseController::checkNull($email)==false){
            return response()->json(['status'=>401,'eror'=>'missing']);
        }else if(BaseController::SQLValidate($email)==true&&BaseController::SQLValidate($username)==true&&$validateMail==true){
                 $check = BaseController::checkExist($email,'users','email');
            if($check!=0){
                return response()->json(['status'=>401,'eror'=>'exist']);
            }else{
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $password = substr(str_shuffle($permitted_chars), 0, 10);
                    $pass1= Hash::make($password);
                    $lastInsertID = DB::Table('users')->insertGetId(['username'=>$username,'password'=>$pass1,'email'=>$email,'created_at'=>now()]);
                    $idStaff= DB::table('role_tbl')->where('roleName','Staff')->value('id');
                    DB::Table('user_role')->insert(['idUser'=>$lastInsertID,'idRole'=>$idStaff,'created_at'=>now()]);
                    $details = [
                        'title' => 'Email th??ng b??o t??i kho???n',
                        'username'=> $username,
                        'password'=> $password,
                        'time'=>'T??i kho???n ???????c t???o v??o l??c: '.date('d/m/yy',time()),
                        'thongbao'=>'Vui l??ng ????ng nh???p v?? thay ?????i m???t kh???u . '
                    ];
                    Mail::to($email)->send(new \App\Mail\EmailThongBao($details));

                    return response()->json(['status'=>200]);
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

            if($check==0||BaseController::getValue('users',$email,'email','status')==0){
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
