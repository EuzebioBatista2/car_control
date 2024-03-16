<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;
    protected $fillable = ['plate', 'brand', 'model', 'year', 'color', 'steering_system', 'type_of_fuel', 'customer_id'];

    /* Foreign key */
    public function customers()
    {
        return $this->belongsTo('App\Models\Customers');
    }

    /* Foreign key */
    public function reviews() {
        return $this->hasMany('App\Modelos\Reviews');
    }
}
