<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginMaster extends Model
{
    use HasFactory;
    protected $table = 'login_masters';
    protected $primaryKey = 'login_id';
}
