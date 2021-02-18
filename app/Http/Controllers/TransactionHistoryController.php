<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;

class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = TransactionHistory::paginate(10)->get();
        return response()->json(['data' => $transactions]);

    }

    public function getSystemSummary()
    {
        $userCount = User::count();
        $walletCount = Wallet::count();
        $balance = Wallet::sum('balance');
        $totalTransactionAmount = TransactionHistory::sum('amount');
        return response()->json(['users' => $userCount,
            'wallets' => $walletCount,
            'totalBalance' => $balance,
            'totalTransaction' =>  $totalTransactionAmount]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
