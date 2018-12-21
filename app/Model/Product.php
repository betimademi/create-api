<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [

        'name',
        'details',
        'stock',
        'price',
        'discount'

        ];


    // Creating Database Tables Relationship/   One Product can have many reviews/  one to many

    public function reviews(){

        return $this->hasMany(Review::class);

    }

}
