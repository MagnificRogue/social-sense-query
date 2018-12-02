<?php

namespace App\Helpers\Application;

use \App\Models\Application;
use \App\Exceptions\HandshakeFailedException;
use GuzzleHttp\Client;

class Handshaker 
{
	protected $application;
	public function __construct(Application $application) {
		$this->application = $application;
 	}	

	public function handshake() {
		$client = new Client();

		try {
			$response = $client->request('POST', $this->application->handshakeUrl, [
				'json' => [
					'user' => [
						'id' => $this->application->user->uuid,
						'name' => $this->application->user->name,
						'email' => $this->application->user->email,
					]
				],
			]);

			if($response->getStatusCode() != 201) {
				throw new HandshakeFailedException();
			}
		} catch (\Exception $e) {
			throw new HandshakeFailedException();
		}
	}
}
