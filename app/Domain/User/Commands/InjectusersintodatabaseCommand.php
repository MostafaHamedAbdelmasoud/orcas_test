<?php

namespace App\Domain\User\Commands;

use App\Domain\User\Entities\Traits\FetchUsersCommandTrait;
use App\Domain\User\Entities\User;
use App\Domain\User\Jobs\CreateFetchedUsersJob;
use App\Infrastructure\Commands\AbstractCommand\BaseCommand as Command;
use Illuminate\Support\Facades\Http;

class InjectusersintodatabaseCommand extends Command
{
    use  FetchUsersCommandTrait;
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
            [$users_1, $users_2] = $this->fetchUserFromEndpoints();

            $users = $this->InjectUsersObjectsIntoArray([$users_1, $users_2]);

            $bar = $this->getOutput()->createProgressBar(
                count($users)
            );

            $bar->start();

            $users = collect($users)->chunk(10);

            dispatch(new CreateFetchedUsersJob($users));

            $bar->finish();

            $this->info("\n");

            $this->warn('Successfully Fetched all users!');


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return 00;
    }


}
