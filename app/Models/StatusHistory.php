<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_history';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'entity_id',
        'entity_type',
        'old_status',
        'new_status',
        'changed_by',
        'changed_at'
    ];

    // Quan hệ với User (người thay đổi)
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
