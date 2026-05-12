<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    protected $fillable = ['name'];
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
