<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kaizen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'no',
        'departement_id',
        'category_id',
        'name',
        'description_old',
        'description_new',
        'benefit',
        'image_old',
        'image_new',
        'status_pic_id',
        'status_secretary_id',
        'review_pic',
        'point_pic',
        'review_secretary',
        'point_secretary',
        'pic_id',
        'secretary_id',

    ];

    public function imageOld(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/kaizens/' . $value)
        );
    }

    public function imageNew(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/kaizens/' . $value)
        );
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function statusPic()
    {
        return $this->belongsTo(Status::class, 'status_pic_id', 'id');
    }

    public function statusSecretary()
    {
        return $this->belongsTo(Status::class, 'status_secretary_id', 'id');
    }

    public function pic()
    {
        return $this->belongsTo(Signature::class, 'pic_id', 'id');
    }

    public function sekretaris()
    {
        return $this->belongsTo(Signature::class, 'secretary_id', 'id');
    }
}
