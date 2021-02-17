<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'wallet_id', 'user_id', 'amount', 'ref', 'status',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }
}
