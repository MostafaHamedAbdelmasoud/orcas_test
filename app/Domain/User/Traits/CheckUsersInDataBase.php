<?php

namespace App\Domain\User\Traits;

use Illuminate\Support\Facades\DB;

trait CheckUsersInDataBase
{

    public function getUserByColumn( $column)
    {
        return DB::table('users')->where($column,$this->user->$column);
    }
}
