<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;
    protected $fillable = ['brand'];

    public function Models() {
        $this->hasMany('App\Models\Admins');
    }
}
