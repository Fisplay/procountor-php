<?php

namespace Procountor\Laravel\Commands;

use Illuminate\Console\Command;

class Authorize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'procountor:authorize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints login URL to generate the authorization code.';

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
        $this->info('Log in & you will be redirected to route which registers the API key.');
        $this->info(sprintf(
            '%s/keylogin?response_type=code&client_id=%s&redirect_uri=%s&state=%s',
            config('procountor.base_uri'),
            config('procountor.client_id'),
            config('procountor.redirect_uri'),
            config('procountor.state_key')
        ));
        return 0;
    }
}
