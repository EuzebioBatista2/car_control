<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lastname', 'email', 'phone', 'age', 'gender', 'admin_id'];

    /* Foreign key */
    public function admins() {
        return $this->belongsTo('App\Models\Admins');
    }

    /* Foreign key */
    public function vehicles() {
        return $this->hasMany('App\Models\Vehicles');
    }
}

