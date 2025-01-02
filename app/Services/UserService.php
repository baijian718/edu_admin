<?php

namespace App\Services;

use App\User;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public static function getUserByUsername($name)
    {
        return Administrator::query()->where("username",$name)->first();
    }

    public static function createUserFromTeacher($sn,$name)
    {
        $info = self::getUserByUsername($sn);
        if (!empty($info)){
            return false;
        }
        $role = AuthService::getTeacherRole();
        if (empty($role)){
            return false;
        }

        $user = new Administrator();
        $user['username'] = $sn;
        $user['name'] = $name;
        $user['password'] = Hash::make("Test@comiru.com");
        DB::beginTransaction();
        if (!$user->save()){
            DB::rollBack();
            return false;
        }
        if (!AuthService::createUserRole($user['id'],$role->id)){
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }
}