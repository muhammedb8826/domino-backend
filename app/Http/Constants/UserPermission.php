<?php
namespace App\Http\Constants;

use App\Http\Constants\Permissions\ReferenceDataPermissions;
use App\Http\Constants\Permissions\UserPermissions;
use ReflectionClass;

class UserPermission implements ReferenceDataPermissions, UserPermissions {

    public static function getConstants(){
        $reflectionClass= new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }

}