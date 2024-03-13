<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Reviews extends Model
{
    use HasFactory;
    protected $fillable = ['date_review', 'problems', 'completed', 'vehicle_id'];

    /* Foreign key */
    public function vehicles() {
        return $this->belongsTo('App\Models\Vehicles');
    }
}
