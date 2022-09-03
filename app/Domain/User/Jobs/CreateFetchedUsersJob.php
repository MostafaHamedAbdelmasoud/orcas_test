<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Entities\User;
use App\Domain\User\Traits\CheckUsersInDataBase;
use App\Domain\User\Traits\InjectUsersDataInDataBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateFetchedUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use CheckUsersInDataBase, InjectUsersDataInDataBase;

    protected $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->users as $usersChunked) {
            $this->iterateOverChunkedUser($usersChunked);

        }

    }

    protected $user;

    /**
     * handle attributes,and create or update users
     *
     * @param $usersChunked
     * @return void
     */
    public function iterateOverChunkedUser($usersChunked)
    {
        $usersChunked->map(function ($user, $key) {

            $this->user = $this->convertUserIntoProperObject($user);

            $this->createOrUpdateUserInDB();

            return 0;

        });
    }

    /**
     * create or update user depending on email
     *
     * @param $user
     * @return void
     */
    public function createOrUpdateUserInDB()
    {
        if ($this->user->email && $this->user->avatar && $this->user->firstName && $this->user->lastName) {

            $userInDataBase = $this->getUserByColumn('email')->first();

            try {
                DB::beginTransaction();

                if (!$userInDataBase) {

                    $this->insertNewUser();

                } else {

                    $this->updateUserWithNewData();

                }

                DB::commit();

            } catch (\Exception $e) {

                Log::info($e->getMessage());

                DB::rollBack();
            }

        }
    }

    public function convertUserIntoProperObject($user)
    {
        return $this->handleUserAttributes(json_decode(json_encode($user), FALSE));
    }

    /**
     * make casting and check if user has same attributes as database or not
     *
     * @param $user
     * @return mixed
     */
    public function handleUserAttributes($user)
    {
        if (isset($user->fName)) {
            $user->firstName = $user->fName;
            $user->lastName = $user->lName;
            $user->avatar = $user->picture;
        }
        return $user;
    }


}
