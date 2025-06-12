<?php

    namespace App\Services;

    use App\Models\Bank;
    use Illuminate\Support\Facades\File;
    use App\Services\LogService;
    use Illuminate\Contracts\View\View;

    class BankService {

        public function all () {
            return Bank ::latest () -> get ();
        }

        public function save ( $request ) {


           $bank = Bank ::create ( [
                            'user_id' => auth()->id(),
                            'bank_name' => $request->bank_name,
                            'bank_code' => $request->bank_code,
                            'bank_branch' => $request->bank_branch,
                            'account_title' => $request->account_title,
                            'account_number' => $request->account_number,
                            'iban' => $request->iban,
                                    ] );


                if ($request->hasFile('logo')) {
                        $path = 'uploads/banks/';
                        $dir = public_path($path);
                        $file = $request->file('logo');

                        if (!File::isDirectory($dir)) {
                            File::makeDirectory($dir, 0755, true, true);
                        }

                        $fileName = time() . '-' . $file->getClientOriginalName();
                        $file->move($dir, $fileName);
                        $bank['file'] = asset($path . $fileName);
                }

            ( new LogService() ) -> log ( 'bank-created', $bank );
            return $bank;
        }



        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> bank_name   = $request -> input ( 'bank_name' );
            $model -> bank_code   = $request -> input ( 'bank_code' );
            $model -> bank_branch   = $request -> input ( 'bank_branch' );
            $model -> account_title   = $request -> input ( 'account_title' );
            $model -> account_number   = $request -> input ( 'account_number' );
            $model -> iban   = $request -> input ( 'iban' );
            if ($request->hasFile('logo')) {
                $path = 'uploads/banks/';
                $dir = public_path($path);
                $file = $request->file('logo');

                if (!File::isDirectory($dir)) {
                    File::makeDirectory($dir, 0755, true, true);
                }

                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move($dir, $fileName);
                $model['file'] = asset($path . $fileName);
            }
            $model -> update ();
            ( new LogService() ) -> log ( 'bank-updated', $model );
        }

        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'bank-deleted', $model );
        }

    }
