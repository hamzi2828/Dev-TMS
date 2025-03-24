<form class="pt-0" method="post"
      action="{{ $candidate -> medical ? route ('candidates.medicals.update', ['candidate' => $candidate -> id, 'medical' => $candidate -> medical -> id]) : route ('candidates.medicals.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> medical)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    Note! Please choose <strong>Payment Method</strong> & <strong>Vendor</strong> carefully,
                    once information is saved in the system this will make impact on <strong>General Ledger</strong> and
                    cannot be reversed.
                </div>
            </div>
         
            {{-- Payment Method Section --}}
            @can('candidate_medical_payment_method', \App\Models\CandidateMedical::class)
            <div class="col-md-3 mb-3">
                <label class="form-label" for="payment-method">
                    Payment Method
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="payment-method" class="form-control select2" required="required"
                        data-placeholder="Select" id="payment-method"
                        @if($candidate->medical?->payment_method_id > 0) disabled="disabled" @endif>
                    <option></option>
                    @if(count($payment_methods) > 0)
                        @foreach($payment_methods as $payment_method)
                            @php $paymentMethodDefault = $candidate->medical?->payment_method_id ?? '1' @endphp
                            <option value="{{ $payment_method->id }}"
                                    @selected(old('payment-method', $paymentMethodDefault) == $payment_method->id)>
                                {{ $payment_method->title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            @endcan

            {{-- Vendor Section --}}
            @can('candidate_medical_vendor', \App\Models\CandidateMedical::class)
            <div class="col-md-3 mb-3">
                <label class="form-label" for="vendor">
                    Vendor
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="vendor-id" class="form-control select2" required="required"
                        data-placeholder="Select" id="vendor"
                        @if($candidate->medical?->vendor_id > 0) disabled="disabled" @endif>
                    <option></option>
                    @if(count($vendors) > 0)
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}"
                                    @selected(old('vendor-id', $candidate->medical?->vendor_id) == $vendor->id)>
                                {{ $vendor->title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            @endcan

            {{-- Transaction No Section --}}
            @can('medical_candidates_trasaction_no', \App\Models\CandidateMedical::class)
            <div class="col-md-3 mb-3">
                <label class="form-label" for="transaction-no">
                    Transaction No
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="text" class="form-control" required="required" minlength="12" maxlength="14"
                    {{ (!empty(trim($candidate->medical?->transaction_no)) > 0 && !auth()->user()->is_admin()) ? 'readonly="readonly"' : '' }}
                    value="{{ old('transaction-no', $candidate->medical?->transaction_no) }}"
                    id="transaction-no" name="transaction-no" />
            </div>
            @endcan



            {{-- status Section  --}}
            @can('medical_candidates_status', \App\Models\CandidateMedical::class)
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" class="form-control select2" data-placeholder="Select"
                            {{ ((!empty(trim ($candidate -> medical ?-> status))) && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                            id="status">
                        <option></option>
                        <option value="hold" @selected(old ('status', $candidate -> medical ?-> status) == 'hold')>
                            Hold
                        </option>
                        <option value="fit" @selected(old ('status', $candidate -> medical ?-> status) == 'fit')>
                            Fit
                        </option>
                        <option value="unfit" @selected(old ('status', $candidate -> medical ?-> status) == 'unfit')>
                            UnFit
                        </option>
                    </select>
                </div>
            @endcan

            {{-- Test Result Section --}}
            @can('medical_candidates_test_result', \App\Models\CandidateMedical::class)
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="results">Test Result</label>
                    @if($candidate -> medical && !empty(trim ($candidate -> medical -> file)))
                        <div>
                            <a href="{{ $candidate -> medical -> file }}"
                               download="{{ $candidate -> fullName() }} - Medical Certificate"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> medical -> file }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" class="form-control" id="results" name="file"
                       accept="image/*">
            </div>
            @endcan

            {{-- Blood Group Section --}}
            @can('medical_candidates_blood_group', \App\Models\CandidateMedical::class)
            <div class="col-md-3 mb-3">
                <label class="form-label" for="blood-group">Blood Group</label>
                <select name="blood-group" class="form-control select2"
                        data-placeholder="Select"
                        id="blood-group">
                    <option></option>
                    <option value="A-" @selected(old ('blood-group', $candidate -> blood_group) == 'A-')>
                        A-
                    </option>
                    <option value="A+" @selected(old ('blood-group', $candidate -> blood_group) == 'A+')>
                        A+
                    </option>
                    <option value="B-" @selected(old ('blood-group', $candidate -> blood_group) == 'B-')>
                        B-
                    </option>
                    <option value="B+" @selected(old ('blood-group', $candidate -> blood_group) == 'B+')>
                        B+
                    </option>
                    <option value="AB-" @selected(old ('blood-group', $candidate -> blood_group) == 'AB-')>
                        AB-
                    </option>
                    <option value="AB+" @selected(old ('blood-group', $candidate -> blood_group) == 'AB+')>
                        AB+
                    </option>
                    <option value="O-" @selected(old ('blood-group', $candidate -> blood_group) == 'O-')>
                        O-
                    </option>
                    <option value="O+" @selected(old ('blood-group', $candidate -> blood_group) == 'O+')>
                        O+
                    </option>
                </select>
            </div>
            @endcan
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        @if($candidate -> medical)
            @can('print_medical_slip', $candidate -> medical)
                <a href="{{ route ('invoices.medical-receipt', ['candidate' => $candidate -> id, 'medical' => $medical -> id]) }}"
                   class="btn btn-dark" target="_blank">Print</a>
            @endcan
        @endif
    </div>
</form>