<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spreadsheet extends Model
{
    // Table Name
    protected $table = 'spreadsheets';
    //Primary key
    public $primaryKey = 'id';
    //timestamps
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
