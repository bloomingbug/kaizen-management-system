<?php

namespace App\Models;

use App\Models\Kaizen;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

    public function kaizens()
    {
        return $this->hasMany(Kaizen::class);
    }

    public function name()
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value)
        );
    }
}
