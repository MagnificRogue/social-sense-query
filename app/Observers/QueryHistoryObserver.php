<?php 

namespace App\Observers;

use App\Models\Query\QueryHistory;
use App\Helpers\Application\QueryHistoryFormatter;
use GuzzleHttp\Client;

class QueryHistoryObserver 
{
    /**
     * Listen to the QueryHistory created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(QueryHistory $history)
    {
		if($history->has_error) {
			return;
		}

		$payload = QueryHistoryFormatter::Format($history);

		$applications = $history->user->applications;
		$client = new Client();
		$applications->each(function($application) use ($payload, $client) {
			try {
				$client->requestAsync('POST', $application->callback, [
					'json' => $payload,
				]);
			} catch (\Exception $e) {
				throw $e;
				// \Log::error($e->getMessage(), ['Payload' => $payload]
			}	
		});
    }
}
