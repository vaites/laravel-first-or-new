<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    protected $fillable = ['name', 'surname'];

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }
}
