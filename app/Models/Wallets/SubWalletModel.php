<?php

namespace App\Models\Wallets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubWalletModel extends Model
{
    use HasFactory;
    protected $table = 'subwallets';
    protected $primaryKey = 'subwallet_id';
    protected $fillable = [
        'target_percentage',
        'wallet_id',
        'stock_types_id'
    ];
}
