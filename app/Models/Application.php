<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\ApplicationSaving;

class Application extends Model
{
	protected $fillable = [	'callback', 'home', 'name', 'description'];
	
	/*
	 * Get the user who owns this callback
	 */
	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function getHandshakeUrlAttribute() {
		return $this->callback . '/handshake';
	}
}
