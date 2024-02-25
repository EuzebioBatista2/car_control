<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'model'];

    public function Brands() {
        $this->belongsTo('App\Models\Brands');
    }
}
