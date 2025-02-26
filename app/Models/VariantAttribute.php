<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
    use HasFactory;
    protected $table = 'variant_attributes';
    protected $fillable = ['variant_id', 'attribute_value_id'];

    public $timestamps = false;

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function nameValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
  
}
