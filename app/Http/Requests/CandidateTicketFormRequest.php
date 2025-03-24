<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CandidateTicketFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> ticket ? $this -> ticket -> id : null;
            return [
                'airline-id' => [ 'nullable', 'numeric', 'exists:airlines,id' ],
                'ticket-no'  => [ 'nullable', 'string', 'unique:candidate_tickets,ticket_no,' . $id ],
                'flight-no'  => [ 'nullable', 'string' ],
                'city-from'  => [ 'nullable', 'numeric', 'exists:cities,id' ],
                'city-to'    => [ 'nullable', 'numeric', 'exists:cities,id' ],
                'agent-id'   => [ 'nullable', 'numeric', 'exists:agents,id' ],
                'dept-date'  => [ 'nullable', 'date' ],
                'dept-time'  => [ 'nullable' ],
                'status'     => [ 'nullable', 'string' ],
            ];
        }
    }
