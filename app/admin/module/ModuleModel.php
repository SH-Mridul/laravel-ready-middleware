<?php

namespace App\admin\module;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table    = 'modules';
    protected $fillable = [
        'name',
        'is_active',
        'soft_delete',
        'created_by',
        'updated_by'
    ];
    
}
