<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WalletStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wallet_name' => [
                'required',
                'string',
                'unique:wallets,wallet_name,NULL,id,user_id,'.auth()->user()->id,
            ],
            'user_id' => ['required', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id'=> auth()->user()->id]);
    }
}
