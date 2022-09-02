<?php

namespace App\Domain\User\Traits;

use Illuminate\Support\Facades\DB;

trait UpdateUsersInDataBase
{

    public function updateUserWithNewData($userInDataBase,)
    {
        $userInDataBase->update([
            'firstName' => $this->user->firstName,
            'lastName' => $this->user->lastName,
            'avatar' => $this->user->avatar,
        ]);
    }
}
