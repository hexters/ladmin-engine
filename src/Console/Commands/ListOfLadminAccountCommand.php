<?php

namespace Ladmin\Engine\Console\Commands;

use Illuminate\Console\Command;
use Ladmin\Engine\Models\Admin;

use function Laravel\Prompts\table;

class ListOfLadminAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ladmin:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of ladmin account';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        table(
            ['Full Name', 'E-Mail Address'],
            Admin::get()->map(fn ($admin) => [$admin->name, $admin->email]),
        );
    }
}
