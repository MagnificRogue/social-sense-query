<?php

namespace App\Helpers\Application;
use App\Models\MetaQuery\Run;
use App\Models\MetaQuery\Stage;
use App\Models\MetaQuery\MetaQueryNode;

class RunFormatter {
	public static function Format(Run $run) {
		$payload = [
			'user' => [
				'id' => $run->metaQuery->user->uuid
			],
			'type' => 'metaQuery',
			'value' => [
				'time' => $run->created_at->timestamp,
				'name' => $run->metaQuery->name,
				'structure' => [
					'stages' => []
				],
				'data' => [
					'stages' => []
				]
			]
		];

		$serializedStages = $run->stages->map(function($stage) {
			return RunFormatter::serializeStage($stage);
		})->toArray();	
		
		$payload['value']['structure']['stages'] = $serializedStages;
		$payload['value']['data']['stages'] = $serializedStages;


		return $payload;
	}


	private static function cleanPath(string $path) {
		$cleanedAsterisks = str_replace(["*"], "", $path);
		return explode(':', $cleanedAsterisks)[0];
	}

	private static function serializeNode(MetaQueryNode $node) {
		$payload = [
			'id' => $node->topology_id,
			'name' => $node->node_name,
			'type' => $node->node_type,
			'status' => $node->status,
			'dependencies' => $node->dependencies->map(function($dependency) {
				return [
					'node_id' => $dependency->output->node->topology_id,
					'output_id' => $dependency->output->id,
					'input_id' => $dependency->input->id,
				];
			})->toArray(),
			'inputs' => $node->inputs->map(function($input) {
				return [
					'input_id' => $input->id,
					'path' => RunFormatter::cleanPath($input->path)
				];
			})->toArray(),
			'outputs' => $node->outputs->map(function($output) {
				return [
					'output_id' => $output->id,
					'path' => RunFormatter::cleanPath($output->path),
					'value' => json_decode($output->value)
				];
			})->toArray(),
		];

		if($node->node_type == 'query') {
			$query = $node->node;
			$payload['structure'] = $query->structure;
		}

		return $payload;
	}	

	private static function serializeStage(Stage $stage) {
		return [
			'nodes' => $stage->nodes->map(function($node) {
				return RunFormatter::serializeNode($node);
			})->toArray()
		];
	}
}
