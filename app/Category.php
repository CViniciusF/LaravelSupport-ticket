<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model

	/*For now we need to manually populate the categories table with some data. I'll be using Laravel artisan's tinker.
	
	php artisan tinker
	$category = new App\Category
	$category->name = "Technical"
	$category->save()

	//If you are new to Laravel artisan's Tinker, you check out this tutorial an Tinker with the Data in Your Laravel Apps with Php Artisan Tinker. To start Tinker run:
	*/
{	
    protected $fillable = ['name'];

    public function tickets()
	{
    	return $this->hasMany(Ticket::class);
	}
}
