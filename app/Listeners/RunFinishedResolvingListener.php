<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Helpers\Application\RunFormatter;
use GuzzleHttp\Client;

class RunFinishedResolvingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
		$payload = RunFormatter::Format($event->run);

		$applications = $event->run->metaQuery->user->applications;
		$client = new Client();
		$applications->each(function($application) use ($payload, $client) {
			try {
				$client->requestAsync('POST', $application->callback, [
					'json' => $payload,
				]);
			} catch (\Exception $e) {
				\Log::error($e->getMessage(), ['Payload' => $payload]);
				throw $e;
			}	
		});
    }
}
