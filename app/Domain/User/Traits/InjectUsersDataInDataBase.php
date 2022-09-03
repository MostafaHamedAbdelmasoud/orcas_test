<?php

namespace App\Domain\User\Traits;

use Illuminate\Support\Facades\DB;

trait InjectUsersDataInDataBase
{

    public function insertNewUser()
    {
        DB::insert('insert into users (email, firstName,lastName,avatar) values (?, ?,?,?)', [
            $this->user->email,
            $this->user->firstName,
            $this->user->lastName,
            $this->user->avatar
        ]);

    }


    public function updateUserWithNewData()
    {
        DB::update(`UPDATE users SET firstName = ? and lastName = ? and avatar = ? WHERE id = ?`,[
            $this->user->firstName,
            $this->user->lastName,
            $this->user->avatar,
            $this->user->email,
        ]);

    }
}
