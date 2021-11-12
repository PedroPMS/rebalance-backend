<?php

namespace App\Models\Wallets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    use HasFactory;
    protected $table = 'wallets';
    protected $primaryKey = 'wallet_id';
    protected $fillable = [
        'wallet_name',
        'user_id'
    ];
}
