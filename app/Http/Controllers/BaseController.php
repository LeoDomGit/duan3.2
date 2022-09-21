<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkNull($item){
        if(trim($item,' ')==''){
            return false;
        }else{
            return true;
        }

    }
    public function SQLValidate($item)
    {

        $pattern = '/(select|Select|SELECT|update|Update|UPDATE|Delete|DELETE|delete) +\w/ ';
        if(trim($item)==''){
            return false;
        }else if(preg_match($pattern,$item)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkExist($item,$table,$column)
    {
        $check = DB::Table($table)->where($column,$item)->count();
        return $check;
    }

    // ====================================

    public function checkInt($item){
        return is_numeric($item);
    }
    // =================================

    public function checkMail($item){
        $check=false;
        // $pattern='/(.+)@(.+)\.(com)/i';
        $pattern2='/(.+)@(leontec.co+)\.(jp)/i';
        if(preg_match($pattern2,$item)){
            $check=true;
        }else{
            $check = false;
        }
        return $check;
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
