<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'user_id', 'category_id', 'ticket_id', 'title', 'priority', 'message', 'status'
	];

	// A ticket can belong to a category, while a category can have many tickets. This is a one to many relationship and we will use Eloquent to setup the relationship.
	public function category()
	{
    	return $this->belongsTo(Category::class);
	}

	public function comments()
	{
    return $this->hasMany(Comment::class);
	}
	public function user()
	{
    return $this->belongsTo(User::class);
	}

}
