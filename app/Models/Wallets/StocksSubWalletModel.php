<?php

namespace App\Models\Wallets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocksSubWalletModel extends Model
{
    use HasFactory;
    protected $table = 'stocks_subwallets';
    protected $primaryKey = 'stocks_subwallet_id';
    protected $fillable = [
        'target_percentage',
        'amount_of_stocks',
        'ceiling_price',
        'subwallet_id',
        'stocks_id'
    ];
}
