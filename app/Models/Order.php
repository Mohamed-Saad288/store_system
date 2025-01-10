<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory , SearchTrait;
    protected $table = 'orders';

    protected $searchable = ['code'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = self::orderBy('id', 'desc')->first();
            $nextCode = $lastOrder ? intval($lastOrder->code) + 1 : 1;
            $order->code = str_pad($nextCode, 4, '0', STR_PAD_LEFT);
        });
    }
    protected $fillable = ["status","total","code","total_before_delivery"];

    public function products()  : BelongsToMany
    {
        return $this->belongsToMany(Product::class,"order_products","order_id","product_id");
    }
    public function order_details()   : HasOne
    {
        return $this->hasOne(OrderDetails::class , "order_id");
    }
    public function order_products() : HasMany
    {
        return $this->hasMany(OrderProduct::class , "order_id");
    }
}
