<?php

namespace App\Jobs;

use App\Strategies\GuardianNewsClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class fetchGuardianApiArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            //get apis from env file
            $guardian_api_url =  config('api.guardian_api_url');

            //fetch data
            $guardian_api_articles = new GuardianNewsClass();
            $guardian_api_status = $guardian_api_articles->fetchArticles($guardian_api_url);

            if($guardian_api_status != "ok") {
                throw new \Exception("Error in Fetching Guardian news articles");
            }

        }catch (\Exception $exception){
            Log::error("error in fetching Guardian articles: " .$exception->getMessage());
        }

    }
}
