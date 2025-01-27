<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class fetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

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
        \App\Jobs\fetchNewsApiArticles::dispatch();
        \App\Jobs\fetchGuardianApiArticles::dispatch();
    }
}
