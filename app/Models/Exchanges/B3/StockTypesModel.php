<?php

namespace App\Models\Exchanges\B3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTypesModel extends Model
{
    use HasFactory;

    protected $table = 'stock_types';
    protected $primaryKey = 'stocks_id';
    protected $fillable = [
        'stock_type'
    ];
}
