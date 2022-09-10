<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Activity;

class FetchData extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fetch activities data and store into database.';

    /**
     * Execute the fetch:data command and store data.
     *
     */
    public function handle() {
        $client = new Client();
        $res = $client->request('GET', getenv('FETCH_URL'));
        // check if status is not scuccess
        if ($res->getStatusCode() !== 200) {
            // Store logs
            \Log::info("Something went wrong! The fetch:data API endpoint is not working.");
            $this->info('fetch:data Command is not working.');
        }
        $response = $res->getBody()->getContents();
        $activityData = json_decode($response, true);
        // Save activity data into database
        Activity::create($activityData);
        // Store logs on success
        \Log::info("fetch:data API executed successfully!");
        $this->info('fetch:data Command is working fine!');
    }

}
