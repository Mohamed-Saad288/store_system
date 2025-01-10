<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory , SearchTrait;

    protected $table = 'products';

    protected $searchable = ["code","name"];
    protected $fillable = [
        "name", "code", "price_before_discount","price_after_discount", "section","status", "image",
    ];
    public function product_features() : HasMany
    {
        return $this->hasMany(ProductFeature::class);
    }
    public function product_descriptions() : HasMany
    {
        return $this->hasMany(ProductDescription::class);
    }
    public function imageLink() : Attribute
    {
      return Attribute::make(
          get: fn () => $this->image ? url("uploads/"."$this->image") : '',
      );
    }
}
