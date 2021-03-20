<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repo1 extends Model
{
    use HasFactory;
    public $fillable=[
        'name','job_id','address'
    ];
}
