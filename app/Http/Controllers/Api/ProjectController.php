<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AllProjects()
    {
        $projects = DB::table('project')->join('users','project.idTeamLead','=','users.id')->get();
        return response()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $projectName = $request->projectName;
        $idUserLeader= $request->idUserTeamLead;
        $projectDescription= $request->projectDescription;
        if(BaseController::SQLValidate($projectName)==false||BaseController::SQLValidate($idUserLeader)==false||BaseController::SQLValidate($projectDescription)==false){
            return response()->json(['status' => false,]);
        }else if(BaseController::checkExist($projectName,'project','project_name')!=0){
            return response()->json(['status' => false,'message'=>'exists']);
        }else if(BaseController::checkExist($idUserLeader,'users','id')==0){
            return response()->json(['status' => false,'message'=>'not found']);
        }else{
            DB::Table('project')->insert(['project_name'=>$projectName,'description'=>$projectDescription,'idTeamLead'=>$idUserLeader,'status'=>1,'created_at'=>now()]);
            return response()->json(['status' => 200,'message'=>'success']);

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
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
    {
        //
    }
}
