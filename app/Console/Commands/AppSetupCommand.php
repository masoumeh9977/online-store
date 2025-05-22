<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('This will remove all data from the database!');

        if ($this->confirm('Do you wish to continue?')) {
            $this->call('migrate:fresh');
            $this->call('db:seed');
            $this->call('iran:import');
            $this->call('make:filament-user', [
                '--name' => 'superadmin',
                '--email' => 'superadmin@gmail.com',
                '--password' => '1234',
            ]);

            $this->info('Application setup completed successfully.');
        } else {
            $this->info('Operation cancelled.');
        }

        return Command::SUCCESS;
    }
}
