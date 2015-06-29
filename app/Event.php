<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

	protected $fillable = ['description', 'duration', 'local_id'];

	public function users()
	{
		return $this->belongsToMany('App\User')->withTimestamps();
	}
}
