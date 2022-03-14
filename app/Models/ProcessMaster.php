<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessMaster extends Model
{
    use HasFactory;

    protected $table = 'processing_master';

    protected $guarded = [];
}
