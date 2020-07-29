<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //



        protected $table = 'drivers';

        //adding one to many relationship between the Users table and the wallet
        public function wallet(){
            return $this->hasMany('App\Models\AppModels\Newwallet');
    
        }

}
