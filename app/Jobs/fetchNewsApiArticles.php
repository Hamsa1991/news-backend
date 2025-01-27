<?php

namespace App\Jobs;

use App\Strategies\NewsApiClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class fetchNewsApiArticles implements ShouldQueue
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
            //get api from config
            $news_api_url = config('api.news_api_url'). '&from=2025-01-24'; //. date('Y-m-d');

            //fetch data
            $news_api_articles = new NewsApiClass();
            $news_api_status = $news_api_articles->fetchArticles($news_api_url);

            if($news_api_status != "ok") {
                throw new \Exception("Error in Fetching News Api articles");
            }

        }catch (\Exception $exception){
            Log::error("Error in fetching News articles: " .$exception->getMessage());
        }
    }
}
