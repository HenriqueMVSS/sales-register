<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'allows_installments',
        'max_installments',
        'active'
    ];

    protected $casts = [
        'allows_installments' => 'boolean',
        'active' => 'boolean'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
