<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sekretaris()
    {
        return $this->hasMany(Kaizen::class, 'secretary_id', 'user_id');
    }

    public function pic()
    {
        return $this->hasMany(Kaizen::class, 'pic_id', 'user_id');
    }
}
