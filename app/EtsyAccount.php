<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtsyAccount extends Model
{
    protected $table = 'etsy_account';

    public $fillalbe = [
        'etsy_email',
        'parent_email',
        'temp_token',
        'secret_key',
        'identifier',
        'etsy_user_id',
        'etsy_shop_id',
    ];
    protected $appends = ['shop_id_array'];

    public function getShopIdArrayAttribute()
    {
        return explode('|',$this->etsy_shop_id);
    }
}
