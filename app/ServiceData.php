<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceData extends Model
{
    protected $fillable = [
        'service_id', 'dataForm'
    ];


    //Relation with service
    public function service()
    {
    	return $this->belongsTo('App\Service','service_id');
    }
}
