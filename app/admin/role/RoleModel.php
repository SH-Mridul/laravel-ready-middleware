<?php

namespace App\admin\role;

use Illuminate\Database\Eloquent\Model;
use App\admin\roleModule\RoleModuleModel;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'is_active',
        'soft_delete',
        'created_by',
        'updated_by'
    ];



    // role module relational function
    
    public function modules(){
        return $this->hasMany(RoleModuleModel::class,'role_id','id');
    }
}
