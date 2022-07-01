<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    protected $fillable = ['address_line', 'postal_code'];

    public function person(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
