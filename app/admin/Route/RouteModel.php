<?php

namespace App\admin\Route;

use Illuminate\Database\Eloquent\Model;
use App\admin\module\ModuleModel;

class RouteModel extends Model
{
    protected $table     = 'routes';
    protected $fillable  = [
        'name',
        'path',
        'type',
        'module_id',
        'is_active',
        'soft_delete',
        'created_by',
        'updated_by'
    ];


    // module 
    public function module(){
        return $this->belongsTo(ModuleModel::class,'module_id','id');
    }
    
    
}
