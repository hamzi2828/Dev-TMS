<?php
    
    namespace App\Services;
    
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidatePaymentFollowUp;
    use App\Models\CandidateTicketFollowUp;
    use App\Models\CandidateVisaFollowUp;
    use App\Models\Fee;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\DB;
    
    class CandidateService {
        
        public function all (): LengthAwarePaginator {
            $candidates = Candidate ::with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            if ( request () -> filled ( 'docs-provided' ) )
                $candidates -> where ( [ 'docs_provided' => request ( 'docs-provided' ) ] );
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'free-candidate' ) )
                $candidates -> where ( [ 'free_candidate' => request ( 'free-candidate' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function interview_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'current_status' => 'interview', 'case_closed' => '0' ] );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT( first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_interviews' )
                        -> where ( [ 'status' => request ( 'status' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function medical_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'case_closed' => '0', 'proceed_to_visa' => '0' ] )
                -> whereIn ( 'current_status', [ 'interview', 'medical' ] )
                -> where ( function ( $query ) {
                    $query
                        -> whereIn ( 'id', function ( $query ) {
                            $query -> select ( 'candidate_id' ) -> from ( 'candidate_interviews' ) -> where ( [ 'status' => 'selected' ] );
                        } );
//                        -> where ( function ( $query ) {
//                            $query -> whereIn ( 'id', function ( $query ) {
//                                $query -> select ( 'candidate_id' ) -> from ( 'candidate_medicals' ) -> whereNull ( 'status' );
//                            } );
//                            $query -> orWhereIn ( 'id', function ( $query ) {
//                                $query -> select ( 'candidate_id' ) -> from ( 'candidate_medicals' ) -> where ( [ 'status' => 'unfit' ] );
//                            } );
//                        } );
                } );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                if ( request ( 'status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_medicals' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_medicals' )
                            -> where ( [ 'status' => request ( 'status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'payment-follow-up' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_payment_follow_ups' )
                        -> where ( [ 'status' => request ( 'payment-follow-up' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function documents_ready_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( function ( $query ) {
                    $query
                        -> whereIn ( 'current_status', [ 'medical' ] )
                        -> orwhereIn ( 'id', function ( $query ) {
                            $query -> select ( 'candidate_id' ) -> from ( 'candidate_document_ready' );
                        } );
                } );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                if ( request ( 'status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_document_ready' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query -> select ( 'candidate_id' ) -> from ( 'candidate_document_ready' ) -> where ( [ 'status' => request ( 'status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            if ( request () -> filled ( 'proceed-to-visa' ) )
                $candidates -> where ( [ 'proceed_to_visa' => request ( 'proceed-to-visa' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function visa_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'case_closed' => '0', 'proceed_to_visa' => '1' ] )
                -> whereIn ( 'current_status', [ 'visa', 'medical' ] )
                -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_medicals' )
                        -> where ( [ 'status' => 'fit' ] );
                } )
                -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_document_ready' )
                        -> where ( [ 'status' => 'yes' ] );
                } );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_visas' )
                        -> where ( [ 'status' => request ( 'status' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'documents-uploaded' ) ) {
                if ( request ( 'documents-uploaded' ) == 'yes' ) {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_visas' )
                            -> whereNotNull ( 'tgid' );
                    } );
                }
                else {
                    $candidates -> where ( function ( $candidates ) {
                        $candidates -> whereIn ( 'id', function ( $query ) {
                            $query
                                -> select ( 'candidate_id' )
                                -> from ( 'candidate_visas' )
                                -> whereNull ( 'tgid' );
                        } ) -> orWhereNotIn ( 'id', function ( $query ) {
                            $query -> select ( 'candidate_id' )
                                -> from ( 'candidate_visas' );
                        } );
                    } );
                }
            }
            
            if ( request () -> filled ( 'visa-follow-up' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_visa_follow_ups' )
                        -> where ( [ 'status' => request ( 'visa-follow-up' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'tgid' ) && is_array ( request ( 'tgid' ) ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_visas' )
                        -> whereIn ( 'tgid', request ( 'tgid' ) );
                } );
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function protector_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'case_closed' => '0' ] )
                -> whereIn ( 'current_status', [ 'visa', 'protector' ] )
                -> whereIn ( 'id', function ( $query ) {
                    $query -> select ( 'candidate_id' ) -> from ( 'candidate_visas' ) -> where ( [ 'status' => 'issued' ] );
                } );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                if ( request ( 'status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' )
                            -> where ( [ 'status' => request ( 'status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function ticket_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'case_closed' => '0' ] )
                -> whereIn ( 'current_status', [ 'ticket', 'protector' ] )
                -> whereIn ( 'id', function ( $query ) {
                    $query -> select ( 'candidate_id' ) -> from ( 'candidate_protectors' );
                } );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'departure-date' ) ) {
                $departure_date = date ( 'Y-m-d', strtotime ( request ( 'departure-date' ) ) );
                $candidates -> whereIn ( 'id', function ( $query ) use ( $departure_date ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_tickets' )
                        -> where ( DB ::raw ( 'DATE(dept_date)' ), '=', $departure_date );
                } );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'status' ) ) {
                if ( request ( 'status' ) == 'waiting' ) {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' );
                    } )
                        -> whereNotIn ( 'id', function ( $query ) {
                            $query
                                -> select ( 'candidate_id' )
                                -> from ( 'candidate_tickets' );
                        } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_tickets' )
                            -> where ( [ 'status' => request ( 'status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'ticket-no' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_tickets' )
                        -> where ( [ 'ticket_no' => request ( 'ticket-no' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'flight-no' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_tickets' )
                        -> where ( [ 'flight_no' => request ( 'flight-no' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'ticket-follow-up' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_ticket_follow_ups' )
                        -> where ( [ 'status' => request ( 'ticket-follow-up' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        public function case_closed_candidates (): LengthAwarePaginator {
            $candidates = Candidate ::active ()
                -> with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source' ] )
                -> where ( [ 'case_closed' => '1' ] );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'candidates' ) && is_array ( request ( 'candidates' ) ) )
                $candidates -> whereIn ( 'id', request ( 'candidates' ) );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            $perPage = 50;
            if ( request () -> has ( 'per-page' ) && request () -> has ( 'per-page' ) >= 50 && request () -> has ( 'per-page' ) <= 500 )
                $perPage = request () -> input ( 'per-page' );
            
            return $candidates -> latest () -> paginate ( $perPage );
        }
        
        function generateSrNo (): string {
            $recordCount = Candidate ::latest () -> first ();
            
            if ( empty( $recordCount ) ) {
                return '001';
            }
            
            $nextNumber = $recordCount -> sr_no + 1;
            
            return sprintf ( '%03d', $nextNumber );
        }
        
        
        public function save ( $request ) {
            $fee       = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $candidate = Candidate ::create ( [
                                                  'user_id'                   => auth () -> user () -> id,
                                                  'sr_no'                     => $this -> generateSrNo (),
                                                  'job_id'                    => $request -> input ( 'job-id' ),
                                                  'qualification_id'          => $request -> input ( 'qualification-id' ),
                                                  'bank_id'                   => $request -> input ( 'bank-id' ),
                                                  'payment_method_id'         => $request -> input ( 'payment-method' ),
                                                  'country_id'                => $request -> input ( 'country-id' ),
                                                  'passport_issue_country_id' => $request -> input ( 'issue-country-id' ),
                                                  'city_id'                   => $request -> input ( 'city-id' ),
                                                  'lead_source_id'            => $request -> input ( 'lead-source-id' ),
                                                  'fee_id'                    => $fee -> id,
                                                  'referral_id'               => $request -> input ( 'referral-id' ),
                                                  'principal_id'              => $request -> input ( 'principal-id' ),
                                                  'province_id'               => $request -> input ( 'province-id' ),
                                                  'district_id'               => $request -> input ( 'district-id' ),
                                                  'first_name'                => $request -> input ( 'first-name' ),
                                                  'last_name'                 => $request -> input ( 'last-name' ),
                                                  'father_name'               => $request -> input ( 'father-name' ),
                                                  'mother_name'               => $request -> input ( 'mother-name' ),
                                                  'mobile'                    => $request -> input ( 'mobile' ),
                                                  'alt_no'                    => $request -> input ( 'alt-no' ),
                                                  'cnic'                      => $request -> input ( 'cnic' ),
                                                  'dob'                       => $request -> input ( 'dob' ),
                                                  'cnic_expiry'               => $request -> input ( 'cnic-expiry-date' ),
                                                  'religion'                  => $request -> input ( 'religion' ),
                                                  'sect'                      => $request -> input ( 'sect' ),
                                                  'marital_status'            => $request -> input ( 'marital-status' ),
                                                  'age'                       => $request -> input ( 'age' ),
                                                  'gender'                    => $request -> input ( 'gender' ),
                                                  'blood_group'               => $request -> input ( 'blood-group' ),
                                                  'contract_period'           => $request -> input ( 'contract-period' ),
                                                  'accommodation'             => $request -> input ( 'accommodation' ),
                                                  'food'                      => $request -> input ( 'food' ),
                                                  'salary'                    => $request -> input ( 'salary' ),
                                                  'passport'                  => $request -> input ( 'passport' ),
                                                  'passport_issue_date'       => $request -> input ( 'passport-issue-date' ),
                                                  'passport_expiry_date'      => $request -> input ( 'passport-expiry-date' ),
                                                  'next_of_kin'               => $request -> input ( 'next-of-kin' ),
                                                  'next_of_kin_cnic'          => $request -> input ( 'next-of-kin-cnic' ),
                                                  'kin_relationship'          => $request -> input ( 'kin-relationship' ),
                                                  'contact_no'                => $request -> input ( 'contact-no' ),
                                                  'shirt_size'                => $request -> input ( 'shirt-size' ),
                                                  'trouser_size'              => $request -> input ( 'trouser-size' ),
                                                  'shoes_size'                => $request -> input ( 'shoes-size' ),
                                                  'weight'                    => $request -> input ( 'weight' ),
                                                  'height'                    => $request -> input ( 'height' ),
                                                  'email'                     => $request -> input ( 'email' ),
                                                  'company_email'             => $request -> input ( 'company-email' ),
                                                  'account_no'                => $request -> input ( 'account-no' ),
                                                  'transaction_no'            => $request -> input ( 'transaction-no' ),
                                                  'address'                   => $request -> input ( 'address' ),
                                                  'free_candidate'            => $request -> input ( 'free-candidate', '0' ),
                                                  'docs_provided'             => $request -> input ( 'docs-provided' ),
                                                  'amount'                    => $fee -> amount,
                                                  'current_status'            => 'interview'
                                              ] );
            ( new LogService() ) -> log ( 'candidate-added', $candidate );
            return $candidate;
        }
        
        public function add_candidate_account_head_id ( $candidate, $account_head_id ): void {
            $candidate -> account_head_id = $account_head_id;
            $candidate -> update ();
        }
        
        public function close_case ( $candidate ): void {
            $candidate -> case_closed    = '1';
            $candidate -> current_status = 'closed';
            $candidate -> update ();
            ( new LogService() ) -> log ( 'candidate-case-closed', $candidate );
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id                   = auth () -> user () -> id;
            $model -> job_id                    = $request -> input ( 'job-id' );
            $model -> qualification_id          = $request -> input ( 'qualification-id' );
            $model -> bank_id                   = $request -> input ( 'bank-id' );
            $model -> country_id                = $request -> input ( 'country-id' );
            $model -> city_id                   = $request -> input ( 'city-id' );
            $model -> lead_source_id            = $request -> input ( 'lead-source-id' );
            $model -> passport_issue_country_id = $request -> input ( 'issue-country-id' );
            $model -> province_id               = $request -> input ( 'province-id' );
            $model -> district_id               = $request -> input ( 'district-id' );
            $model -> first_name                = $request -> input ( 'first-name' );
            $model -> last_name                 = $request -> input ( 'last-name' );
            $model -> father_name               = $request -> input ( 'father-name' );
            $model -> mother_name               = $request -> input ( 'mother-name' );
            $model -> mobile                    = $request -> input ( 'mobile' );
            $model -> alt_no                    = $request -> input ( 'alt-no' );
            $model -> cnic                      = $request -> input ( 'cnic' );
            $model -> dob                       = $request -> input ( 'dob', null );
            $model -> cnic_expiry               = $request -> input ( 'cnic-expiry-date' );
            $model -> religion                  = $request -> input ( 'religion' );
            $model -> sect                      = $request -> input ( 'sect' );
            $model -> marital_status            = $request -> input ( 'marital-status' );
            $model -> age                       = $request -> input ( 'age' );
            $model -> gender                    = $request -> input ( 'gender' );
            $model -> blood_group               = $request -> input ( 'blood-group' );
            $model -> contract_period           = $request -> input ( 'contract-period' );
            $model -> accommodation             = $request -> input ( 'accommodation' );
            $model -> food                      = $request -> input ( 'food' );
            $model -> salary                    = $request -> input ( 'salary' );
            $model -> passport                  = $request -> input ( 'passport' );
            $model -> passport_issue_date       = $request -> input ( 'passport-issue-date' );
            $model -> passport_expiry_date      = $request -> input ( 'passport-expiry-date' );
            $model -> next_of_kin               = $request -> input ( 'next-of-kin' );
            $model -> next_of_kin_cnic          = $request -> input ( 'next-of-kin-cnic' );
            $model -> kin_relationship          = $request -> input ( 'kin-relationship' );
            $model -> contact_no                = $request -> input ( 'contact-no' );
            $model -> shirt_size                = $request -> input ( 'shirt-size' );
            $model -> trouser_size              = $request -> input ( 'trouser-size' );
            $model -> shoes_size                = $request -> input ( 'shoes-size' );
            $model -> weight                    = $request -> input ( 'weight' );
            $model -> height                    = $request -> input ( 'height' );
            $model -> email                     = $request -> input ( 'email' );
            $model -> company_email             = $request -> input ( 'company-email' );
            $model -> account_no                = $request -> input ( 'account-no' );
            $model -> transaction_no            = $request -> input ( 'transaction-no' );
            $model -> address                   = $request -> input ( 'address' );
            $model -> docs_provided             = $request -> input ( 'docs-provided' );
            
            if ( $request -> filled ( 'payment-method' ) )
                $model -> payment_method_id = $request -> input ( 'payment-method' );
            
            if ( $request -> filled ( 'referral-id' ) )
                $model -> referral_id = $request -> input ( 'referral-id' );
            
            if ( $request -> filled ( 'principal-id' ) )
                $model -> principal_id = $request -> input ( 'principal-id' );
            
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-updated', $model );
        }
        
        public function save_trade_change ( $request, $model ): void {
            $model -> tc_job_id = $request -> input ( 'job-id' );
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-trade-change-added', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-deleted', $model );
        }
        
        public function update_discount ( $request, $model ) {
            $invoiceNo                           = ( new GeneralHelper() ) -> generateRandomString ( 4 );
            $model -> discount                   = $request -> input ( 'discount' );
            $model -> discount_ledger_invoice_no = $invoiceNo;
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-discount-added', $model );
            return $model;
        }
        
        public function status_check (): Collection | array {
            $candidates = Candidate ::with ( [ 'job', 'qualification', 'bank', 'payment_method', 'country', 'city', 'source', 'transactions' => fn ( $q ) => $q -> whereNotNull ( 'voucher_no' ) ] );
            
            if ( request () -> filled ( 'sr-no' ) )
                $candidates -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $candidates -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [ $start_date, $end_date ] );
            }
            
            if ( request () -> filled ( 'name' ) ) {
                $candidates -> where ( DB ::raw ( "CONCAT(first_name,' ',COALESCE(last_name, ''))" ), 'LIKE', '%' . request ( 'name' ) . '%' );
            }
            
            if ( request () -> filled ( 'mobile' ) )
                $candidates -> where ( [ 'mobile' => request ( 'mobile' ) ] );
            
            if ( request () -> filled ( 'cnic' ) )
                $candidates -> where ( [ 'cnic' => request ( 'cnic' ) ] );
            
            if ( request () -> filled ( 'passport' ) )
                $candidates -> where ( [ 'passport' => request ( 'passport' ) ] );
            
            if ( request () -> filled ( 'job-id' ) )
                $candidates -> where ( [ 'job_id' => request ( 'job-id' ) ] );
            
            if ( request () -> filled ( 'referral-id' ) )
                $candidates -> where ( [ 'referral_id' => request ( 'referral-id' ) ] );
            
            if ( request () -> filled ( 'payment-status' ) && request ( 'payment-status' ) == 'not-submitted' ) {
                $candidates
                    -> whereNotIn ( 'account_head_id', function ( $query ) {
                        $query
                            -> select ( 'account_head_id' )
                            -> from ( 'general_ledgers' )
                            -> whereNull ( 'invoice_no' );
                    } );
            }
            
            if ( request () -> filled ( 'payment-status' ) && request ( 'payment-status' ) == 'submitted' ) {
                $candidates -> whereIn ( 'account_head_id', function ( $query ) {
                    $query -> select ( 'account_head_id' ) -> from ( 'general_ledgers' ) -> whereNotNull ( 'voucher_no' );
                } );
            }
            
            if ( request () -> filled ( 'interview-status' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_interviews' )
                        -> where ( [ 'status' => request ( 'interview-status' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'medical-status' ) ) {
                if ( request ( 'medical-status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_medicals' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_medicals' )
                            -> where ( [ 'status' => request ( 'medical-status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'document-ready-status' ) ) {
                if ( request ( 'document-ready-status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_document_ready' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_document_ready' )
                            -> where ( [ 'status' => request ( 'document-ready-status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'documents-uploaded' ) ) {
                if ( request ( 'documents-uploaded' ) == 'yes' ) {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_visas' )
                            -> whereNotNull ( 'tgid' );
                    } );
                }
                else {
                    $candidates -> where ( function ( $candidates ) {
                        $candidates
                            -> whereIn ( 'id', function ( $query ) {
                                $query
                                    -> select ( 'candidate_id' )
                                    -> from ( 'candidate_visas' )
                                    -> whereNull ( 'tgid' );
                            } )
                            -> orWhereNotIn ( 'id', function ( $query ) {
                                $query -> select ( 'candidate_id' )
                                    -> from ( 'candidate_visas' );
                            } );
                    } );
                }
            }
            
            if ( request () -> filled ( 'visa-status' ) ) {
                $candidates -> whereIn ( 'id', function ( $query ) {
                    $query
                        -> select ( 'candidate_id' )
                        -> from ( 'candidate_visas' )
                        -> where ( [ 'status' => request ( 'visa-status' ) ] );
                } );
            }
            
            if ( request () -> filled ( 'protector-status' ) ) {
                if ( request ( 'protector-status' ) == '0' ) {
                    $candidates -> whereNotIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' );
                    } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' )
                            -> where ( [ 'status' => request ( 'protector-status' ) ] );
                    } );
                }
            }
            
            if ( request () -> filled ( 'ticket-status' ) ) {
                if ( request ( 'ticket-status' ) == 'waiting' ) {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_protectors' );
                    } )
                        -> whereNotIn ( 'id', function ( $query ) {
                            $query
                                -> select ( 'candidate_id' )
                                -> from ( 'candidate_tickets' );
                        } );
                }
                else {
                    $candidates -> whereIn ( 'id', function ( $query ) {
                        $query
                            -> select ( 'candidate_id' )
                            -> from ( 'candidate_tickets' )
                            -> where ( [ 'status' => request ( 'ticket-status' ) ] );
                    } );
                }
            }
            
            return $candidates -> latest () -> get ();
        }
        
        public function clear_accounts ( $model ): void {
            $model -> cleared_payments = '1';
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-amount-cleared', $model );
        }
        
        public function proceed_to_visa ( $model ): void {
            $model -> proceed_to_visa = '1';
            $model -> update ();
            ( new LogService() ) -> log ( 'candidate-proceeded-to-visa', $model );
        }
        
        public function save_payment_remarks ( $candidate, $request ): void {
            $candidate -> payment_remarks = $request -> input ( 'payment-remarks' );
            $candidate -> update ();
            ( new LogService() ) -> log ( 'candidate-payment-remarks-added', $candidate );
        }
        
        public function status_change ( $candidate, $request ): void {
            $candidate -> active = $candidate -> active == '1' ? '0' : '1';
            $candidate -> update ();
            ( new LogService() ) -> log ( 'candidate-status-changed', $candidate );
        }
        
        public function arrived ( $candidate, $request ): void {
            $candidate -> arrived = $candidate -> arrived == '1' ? '0' : '1';
            $candidate -> update ();
            ( new LogService() ) -> log ( 'candidate-arrived-changed', $candidate );
        }
        
        public function save_interview ( $candidate ) {
            $candidate -> current_status = 'interview';
            $candidate -> update ();
            
            return CandidateInterview ::create ( [
                                                     'user_id'      => auth () -> user () -> id,
                                                     'candidate_id' => $candidate -> id,
                                                     'status'       => 'standby',
                                                 ] );
        }
        
        public function save_payment_follow_up ( $candidate ) {
            return CandidatePaymentFollowUp ::create ( [
                                                           'user_id'      => null,
                                                           'candidate_id' => $candidate -> id,
                                                           'status'       => 'not-informed',
                                                       ] );
        }
        
        public function save_visa_follow_up ( $candidate ) {
            return CandidateVisaFollowUp ::create ( [
                                                        'user_id'      => null,
                                                        'candidate_id' => $candidate -> id,
                                                        'status'       => 'not-informed',
                                                    ] );
        }
        
        public function save_ticket_follow_up ( $candidate ) {
            return CandidateTicketFollowUp ::create ( [
                                                          'user_id'      => null,
                                                          'candidate_id' => $candidate -> id,
                                                          'status'       => 'not-informed',
                                                      ] );
        }
    }
