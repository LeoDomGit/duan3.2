<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $table='project';
    protected $fillable=['idProject','project_name','description','note','idTeamLead','status','created_at','updated_at'];
    use HasFactory;
}
