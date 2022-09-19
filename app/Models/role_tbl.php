<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_tbl extends Model
{
    protected $table='role_tbl';
    protected $fillable=['id','roleName','created_at','updated_at'];
    use HasFactory;
}
