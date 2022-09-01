<?php

namespace App\Domain\User\Entities\Traits;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;

/**
 *
 */
trait FetchUsersCommandTrait
{


    /**
     * convert users array to object
     *
     * @param $usersArray
     * @param $result
     * @return mixed
     */
    public function extractUsersObjects($usersArray, $result)
    {
        foreach ($usersArray as $userObject) {

            $userObject = json_decode(json_encode($userObject), FALSE);

            $result[] = $userObject;
        }
        return $result;
    }

    /**
     * get the final result of users array
     *
     * @param array $usersArr
     * @return array
     */
    public function InjectUsersObjectsIntoArray(array $usersArr): array
    {
        $result = [];

        foreach ($usersArr as $usersArray) {

            $result = $this->extractUsersObjects($usersArray, $result);
        }

        return $result;
    }


    /**
     * fetch users from the given endpoints
     *
     * @return array|void
     */
    public function fetchUserFromEndpoints()
    {

        $users_1 = Http::get('https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/users_1');

        $users_2 =  Http::get('https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/user_2');

        if ($users_1->successful() && $users_2->successful()) {

            return [$users_1->json(), $users_2->json()];

        } else {

            $users_1->failed() ? $users_1->throw() : $users_2->throw();

        }

    }

}
