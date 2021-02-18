<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::paginate(10);
        return response()->json(['data' => $wallets]);

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

    public function creditWallet(Wallet $walletId)
    {
        DB::beginTransaction();
        try {
            $amount = request('amount');
            $receiverWalletId = request('receiverWalletId');
            $senderWalletId = request('senderWalletId');

            if ($senderWalletId === $receiverWalletId) {
                return response()->json(['data' => false, "message" => "Wallet account is the same"]);
            }
            // deduct amount from wallet first
            $senderWallet = Wallet::where('wallet_long_id', $senderWalletId)->first();
            $wallet_balance = $senderWallet->balance;
            if ($wallet_balance > $amount) {
                $senderbalance = $wallet_balance - $amount;
                $senderWallet->update(['balance' => $senderbalance]);
                TransactionHistory::create([
                    'ref' => Str::uuid()->toString(),
                    'amount' => $amount,
                    'status' => "Wallet Deducted",
                    'user_id' => $senderWallet->user_id,
                    'wallet_id' => $senderWallet->id,
                ]);
            } else {
                return response()->json(['data' => false, "message" => "Insufficient balance in wallet"]);
            }
            // credit the receiver wallet
            $receiverWallet = Wallet::where('wallet_long_id', $receiverWalletId)->first();
            $wallet_balance = $receiverWallet->balance;
            $receiverbalance = $wallet_balance + $amount;
            $receiverWallet->update(['balance' => $receiverbalance]);
            TransactionHistory::create([
                'ref' => Str::uuid()->toString(),
                'amount' => $amount,
                'status' => "Wallet Credited",
                'user_id' => $receiverWallet->user_id,
                'wallet_id' => $receiverWallet->id,
            ]);
            DB::commit();
            return response()->json(["balance" => $senderbalance, "message" => "Wallet credited successfully"]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["data" => false, "message" => "An error occured while funding wallet" + $e]);
        }

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

    public function getWalletDetails(Wallet $walletId)
    {
        $walletId = request('walletId');
        $wallet = Wallet::where('id', $walletId)->with("user", "transaction_histories")->get();
        return response()->json(['data' => $wallet]);

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
