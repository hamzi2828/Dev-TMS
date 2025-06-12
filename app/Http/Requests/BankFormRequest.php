<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class BankFormRequest extends FormRequest {

        public function authorize (): bool {
            return true;
        }

        public function rules (): array {
            return [
                'bank_name' => 'required|string|max:255',
                'bank_code' => 'required|string|max:255',
                'bank_branch' => 'required|string|max:255',
                'account_title' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }
    }
