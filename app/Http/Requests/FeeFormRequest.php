<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class FeeFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $fee_id = $this -> fee ? $this -> fee -> id : null;
            return [
                'title'  => [ 'required', 'string', 'min:3', 'unique:fees,title,' . $fee_id ],
                'amount' => [ 'required', 'numeric', 'min:0' ],
            ];
        }
    }
