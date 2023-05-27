<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = ['vehiclePlate', 'entryDateTime', 'exitDateTime', 'priceType', 'price'];
    public $timestamps = false;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
