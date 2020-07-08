<?php

namespace App\admin\roleUser;
use App\User;
use App\admin\role\RoleModel;

use Illuminate\Database\Eloquent\Model;

class RoleUserModel extends Model
{
    protected $table = 'role_user_details';
    protected $fillable = [
        'role_id',
        'user_id',
        'is_active',
        'soft_delete',
        'created_by',
        'updated_by'
    ];


    // role relational funtcion
    public function role(){
        return $this->belongsTo(RoleModel::class,'role_id','id');
    }
}
