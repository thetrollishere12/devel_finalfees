<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    // Table Name
    protected $table = 'sales';
    //Primary key
    public $primaryKey = 'id';
    //timestamps
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
