<?php

namespace App\Observers;

use App\Models\Application;
use App\Helpers\Application\Handshaker;

class ApplicationObserver
{
	public function saving(Application $application) {
		$handshaker = new Handshaker($application);
		$handshaker->handshake();
	}
}
