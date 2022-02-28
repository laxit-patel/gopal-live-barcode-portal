<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMaster extends Model
{
    use HasFactory;
    protected $table = 'access_master';
    public $timestamps = false;

    protected $guarded = [];
}
