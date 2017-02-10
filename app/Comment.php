<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	/*
	A Comment can belong to a Ticket, while a Ticket can have many Comments. This is a one to many relationship and we will use Eloquent to setup the relationship. 
	*/
    protected $fillable = [
    'ticket_id', 'user_id', 'comment'
	];

	public function ticket()
	{
    return $this->belongsTo(Ticket::class);
	}
	public function user()
	{
    return $this->belongsTo(User::class);
	}
}
