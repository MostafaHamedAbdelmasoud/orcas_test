<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateFetchedUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        foreach ($this->users as $userChunked) {

            $userChunked->map(function ($user, $key) {

                $user = json_decode(json_encode($user), FALSE);

                $user = $this->handleUserAttributes($user);

                if ($user->email && $user->avatar && $user->firstName && $user->lastName) {
                    return User::firstOrCreate([
                        'email' => $user->email,
                    ], [
                        'firstName' => $user->firstName,
                        'lastName' => $user->lastName,
                        'avatar' => $user->avatar,
                    ]);
                }
                return 0;

            });
        }

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


//    public function InjectUniqueUserInDatabase($user)
//    {
//        DB::table('users')->
//    }
}
