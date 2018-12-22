<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=[

        'customer',
        'review',
        'star'

    ];

    // HERE WE CREATE ALSO THE RELATIONSHIP BETWEEN PRODUCTS AND REVIEWS AND WE TELL THAT THIS PRODUCT BELONGS TO REVIEWS
    public function product()
    {
        return $this->belongsTo(Product::class);

    }

}
