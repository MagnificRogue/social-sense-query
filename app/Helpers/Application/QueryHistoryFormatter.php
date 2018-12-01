<?php

use App\Models\Query\QueryHistory;

namespace App\Helpers\Application;

class QueryHistoryFormatter {

	public static function Format(QueryHistory $history) {
		$payload = [
				'user' => [
					'id' => $history->user->uuid,
				],
				'type' => 'query',
				'value' => [
					'id' => $history->queryOfRecord->id,
					'data' => $history->data,
					'time' => $history->created_at->timestamp,
					'name' => $history->queryOfRecord->name,
					'structure' => $history->query_structure,
				]
			];
		
		return $payload;
	}
}
		
