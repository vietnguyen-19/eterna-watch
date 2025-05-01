<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_status',
        'transaction_id',
        'txn_ref',
        'transaction_no',
        'transaction_date', 
        'payment_date',
    ];

    // Quan hệ với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
