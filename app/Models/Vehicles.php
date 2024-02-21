<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;
    protected $fillable = ['brand', 'model', 'year', 'color', 'steering_system', 'type_of_fuel', 'customer_id'];

    public function customers()
    {
        return $this->belongsTo('App\Models\Customers');
    }
}
