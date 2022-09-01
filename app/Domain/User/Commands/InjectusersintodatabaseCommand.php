<?php

namespace App\Domain\User\Commands;

use App\Domain\User\Entities\User;
use App\Infrastructure\Commands\AbstractCommand\BaseCommand as Command;
use Illuminate\Support\Facades\Http;

class InjectusersintodatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InjectUsersIntoDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inject users into database command every 8 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $users_1 = Http::get('https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/users_1');
            $users_2 = Http::get('https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/user_2');


            if ($users_1->successful()) {
                $users_1 = $users_1->json($key = null);

                $bar = $this->getOutput()->createProgressBar(
                    count($users_1)
                );

                $bar->start();

                $users_2 = $users_2->json($key = null);
                $bar->finish();

                collect($users_1)->map(function ($user, $key) {
                    $user= json_decode(json_encode($user), FALSE);

                    if (isset($user->fName)) {
                        $user->firstName = $user->fName;
                        $user->lastName = $user->lName;
                    }

                    if ($user->email && $user->avatar && $user->firstName && $user->lastName) {
                        return User::firstOrCreate([
                            'email' => $user->email,
                        ], [
                            'firstName'=>$user->firstName,
                            'lastName'=>$user->lastName,
                            'avatar'=>$user->avatar,
                        ]);
                    }
                    return 0;

                });


//                dd($users_1);

                $this->warn('Successfully Fetched all users!');

                $this->info("\n");
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return 00;
    }

}
