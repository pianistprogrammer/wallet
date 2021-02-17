<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['balance','name','user_id','monthly_interest_rate','wallet_long_id'];
   
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function transaction_histories()
    {
        return $this->hasMany('App\Models\TransactionHistory');
    }
}
