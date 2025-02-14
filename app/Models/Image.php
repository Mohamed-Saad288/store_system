<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ["image"];
    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }
    public function imageLink(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? url($this->image) : null
        );
    }
}
