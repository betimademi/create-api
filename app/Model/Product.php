<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Creating Database Tables Relationship/   One Product can have many reviews/  one to many

    public function reviews(){

        return $this->hasMany(Review::class);

    }

}
