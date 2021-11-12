<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class WalletUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $urlWalletId = $this->segment(3);
        return [
            'wallet_name' => [
                'required',
                'string',
                "unique:wallets,wallet_name,$urlWalletId,wallet_id,user_id,".auth()->user()->id,
            ],
            'user_id' => ['required', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id'=> auth()->user()->id]);
    }
}
