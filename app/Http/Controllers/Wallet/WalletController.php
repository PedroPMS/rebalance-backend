<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\WalletStore;
use App\Http\Requests\Wallet\WalletUpdate;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallets\WalletModel;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(): object
    {
        $userId = auth()->user()->getKey();
        $wallets = WalletModel::where('user_id', $userId);
        return WalletResource::collection($wallets->get());
    }

    public function store(WalletStore $request): WalletResource
    {
        $newWallet = WalletModel::create($request->all());
        return new WalletResource($newWallet);
    }

    public function show(WalletModel $wallet): WalletResource
    {
        return new WalletResource($wallet);
    }

    public function update(WalletUpdate $request, WalletModel $wallet): WalletResource
    {
        $wallet->update($request->all());
        return new WalletResource($wallet);
    }

    public function destroy(WalletModel $wallet): object
    {
        $wallet->delete();
        return response()->json(['message' => 'OK']);
    }
}
