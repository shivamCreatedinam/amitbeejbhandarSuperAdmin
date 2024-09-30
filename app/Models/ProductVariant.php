<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable =['product_id','variant_name','quantity','unit','total_stock','mrp','selling_price','packing','discount','image'];

    /**
     * Mutator to set the variant_name to uppercase.
     */
    public function setVariantNameAttribute($value)
    {
        $this->attributes['variant_name'] = strtoupper($value);
    }
    // protected $with = ['product'];

    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class, 'product_id', 'id');
    // }
}
