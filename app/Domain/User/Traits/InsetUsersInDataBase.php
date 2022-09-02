<?php

namespace App\Domain\User\Traits;

use Illuminate\Support\Facades\DB;

trait InsetUsersInDataBase
{

    public function insertNewUser()
    {
        DB::table('users')->insert([
            'email' => $this->user->email,
            'firstName' => $this->user->firstName,
            'lastName' => $this->user->lastName,
            'avatar' => $this->user->avatar,
        ]);;
    }
}
