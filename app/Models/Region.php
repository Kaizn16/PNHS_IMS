<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $primaryKey = 'region_id';
    protected $fillable = [
        'region_name',
        'region_description',
    ];
}
