<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $fillable=['role_id','user_id', 'user_type'];
}
