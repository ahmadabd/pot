<?php

namespace App\Console\Commands;

use App\Services\Notification\WateringNotifyImp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WateringToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns all the flowers that should be watered today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private WateringNotifyImp $notify)
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
        $request = Request::create(route('watering.today.all'), 'GET');
        $response = app()->handle($request);

        $data = json_decode($response->getContent())->data;

        // send notification to users that their flowers should get water today
        $this->notify->WateringNotify($data);        
        
        Log::info('Watering:today command executed today at: ' . Carbon::now());
        
        return 0;
    }
}
