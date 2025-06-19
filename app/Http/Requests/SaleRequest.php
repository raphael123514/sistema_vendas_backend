<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller_id' => 'required|exists:sellers,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ];
    }
}
