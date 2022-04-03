<?php

namespace App\Console\Commands;

use App\Services\Notification\FertilizeNotifyImp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FertilizingToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fertilizing:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns all the flowers that should be fertilize today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private FertilizeNotifyImp $notify)
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
        $request = Request::create(route('fertilizing.today.all'), 'GET');
        $response = app()->handle($request);

        $data = @json_decode($response->getContent())->data;

        // send notification to users that their flowers should get fertilize today
        if (!empty($data)) {
            $this->notify->FertilizeNotify($data);
        }

        Log::info('fertilizing:today command executed at: ' . Carbon::now());

        return 0;
    }
}
