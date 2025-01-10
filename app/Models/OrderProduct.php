<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Queue\Connectors\BeanstalkdConnector;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'order_products';
    protected $fillable = ["order_id", "product_id", "count","price"];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
