<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;

class Newwallet extends Model
{
    //


    protected $table = 'wallet';
    

      //connect to the relationship from here
      public function user(){
        return $this->belongsTo('App\Models\AppModels\Customer');
    }
}
