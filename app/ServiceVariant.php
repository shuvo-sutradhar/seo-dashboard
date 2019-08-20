<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceVariant extends Model
{
    protected $fillable = [
        'service_id', 'variant_name', 'variant_value'
    ];



    //Relation with service
    public function service()
    {
    	return $this->belongsTo('App\Service');
    }
}
