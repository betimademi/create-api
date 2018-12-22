<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
    // whenever this exception is called we will return this function
    public function render(){

        return ['errors'=>'Product Not Belongs to User'];
    }
}
