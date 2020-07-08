<?php

namespace App\admin\roleModule;

use Illuminate\Database\Eloquent\Model;
use App\admin\module\ModuleModel;

class RoleModuleModel extends Model
{
    protected $table ='role_module_details';
    protected $fillable =[
        'role_id',
        'module_id',
        'is_active',
        'soft_delete',
        'created_by',
        'updated_by'
    ];

    // module relational function 
    public function module(){
        return $this->belongsTo(ModuleModel::class,'module_id','id');
    }
}
