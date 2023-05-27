<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    public function serviceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'userId');
    }

    public static function finById($id)
    {
        return self::where('id', $id)->first();
    }
}
