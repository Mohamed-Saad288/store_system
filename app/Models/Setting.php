<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ["governorate_id", "delivery"];

    public function governorate() : BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }
}
