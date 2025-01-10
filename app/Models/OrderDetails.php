<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = ["order_id", "city", "name", "phone","address","governorate_id"];

    public function governorate() : BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }
}
