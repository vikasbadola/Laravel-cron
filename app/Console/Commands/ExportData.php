<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Activity;

class ExportData extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to export report into public folder.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $activityReport = Activity::select('type', \DB::raw('MAX(price) as maxPrice'),
            \DB::raw('ROUND(AVG(price),2) as averagePrice'),
            \DB::raw('SUM(participants) as totalParticipants'))
            ->groupBy('type')
            ->get();
        //Storing the csv file in public >> downloads folder.
        if (!\File::exists(public_path()."/download")) {
            \File::makeDirectory(public_path() . "/download");
        }
        //creating the download file
        $filename =  public_path("download/report-".date('Y-m-d-H-i-s').".csv");
        $handle = fopen($filename, 'w');
        //adding the headers
        fputcsv($handle, [
            "Type",
            "Max Price",
            "Average Price",
            "Total Participants",
        ]);
        //adding the data from the query
        foreach ($activityReport as $each_user) {
            fputcsv($handle, [
                $each_user->type,
                $each_user->maxPrice,
                $each_user->averagePrice,
                $each_user->totalParticipants,
            ]);
        }
        fclose($handle);
        // Store logs on success
        \Log::info("export:data command executed successfully!");
        $this->info('export:data command is working fine!');
    }

}
