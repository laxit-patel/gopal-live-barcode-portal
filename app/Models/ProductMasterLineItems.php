<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMasterLineItems extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = "product_master_line_items";

    protected $guarded = [];

}
