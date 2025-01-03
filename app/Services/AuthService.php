<?php

namespace App\Services;

use App\User;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\DB;

class AuthService extends BaseService
{
    public static function getRoleByTag($name)
    {
        return DB::table(config('admin.database.roles_table'))->where('slug', $name)->first();
    }

    public static function userIsTheRole($userId, $roleId)
    {
        $list = self::getUserRoleIds($userId);
        $list = is_array($list) ? $list : [];
        if (in_array($roleId, $list)){
            return true;
        }
        return false;
    }

    public static function getUserRoleIds($userId)
    {
        $list = self::getUserRoles($userId);
        if (empty($list)){
            return  [];
        }
        return $list->pluck('role_id')->toArray();
    }

    public static function getUserRoles($userId)
    {
        return DB::table(config('admin.database.role_users_table'))
            ->query()->where('user_id', $userId)->get();
    }

    public static function getTeacherRole()
    {
        return self::getRoleByTag(User::ROLE_TEACHER);
    }

    public static function createUserRole($userId,$roleId)
    {
        return DB::table(config('admin.database.role_users_table'))->insert([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
    }
}