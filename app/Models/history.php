<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    protected $table='history_tbl';
    protected $fillable=['id','username','content','created_at','updated_at'];
    use HasFactory;
}
