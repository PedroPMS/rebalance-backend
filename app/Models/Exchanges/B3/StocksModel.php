<?php

namespace App\Models\Exchanges\B3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocksModel extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'stock_types_id';
    protected $fillable = [
        'name',
        'stock_types_id',
        'actual_price',
        'previous_close',
        'variation',
        'perc_variation',
    ];
}
