<div class="card-body pt-1 pb-1">
    @include('candidates.edit.candidate-info')
    <div class="d-flex justify-content-end gap-3">
        @can('candidate_clear_accounts', $candidate)
            @if($candidate -> cleared_payments != '1')
                <form method="post"
                      action="{{ route ('candidates.clear-accounts', ['candidate' => $candidate -> id]) }}"
                      class="d-flex justify-content-end pb-3">
                    @method('PUT')
                    @csrf
                    <button class="btn btn-danger" type="submit"
                            onclick="return confirm('Are you sure? Action is irreversible.')">Clear Accounts
                    </button>
                </form>
            @endif
        @endcan
        @can('candidate_proceed_to_visa', $candidate)
            @if($candidate -> proceed_to_visa != '1' && $candidate -> medical ?-> status == 'fit')
                <form method="post"
                      action="{{ route ('candidates.proceed-to-visa', ['candidate' => $candidate -> id]) }}"
                      class="d-flex justify-content-end pb-3">
                    @method('PUT')
                    @csrf
                    <button class="btn btn-success" type="submit"
                            onclick="return confirm('Are you sure? Action is irreversible.')">Proceed to Visa
                    </button>
                </form>
            @elseif($candidate -> medical ?-> status != 'fit')
                <a href="javascript:void(0)" class="btn btn-danger h-100">
                    Candidate is not FIT & cannot be proceeded to visa.
                </a>
            @endif
        @endcan
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-secondary">
                <th class="text-dark">Sr.No</th>
                <th class="text-dark">Service</th>
                <th class="text-dark">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>{{ $candidate -> fee ?-> title }}</td>
                <td>{{ number_format ($candidate -> amount, 2) }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Medical Fee</td>
                <td>{{ number_format ($candidate -> medical ?-> amount, 2) }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Total Agreed Payment</td>
                <td>
                    @php
                        $professionFee = \App\Models\PrincipalJob::where(['principal_id' => $candidate -> principal_id, 'job_id' => $candidate -> job_id]) -> first();
                    @endphp
                    {{ number_format ($professionFee ?-> fee, 2) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <div class="row mt-3 mb-3">
        <div class="d-flex justify-content-between align-items-center pt-2 pb-2 bg-dark">
            <h4 class="text-white fw-semibold mb-0">Payments</h4>
            <a href="{{ route ('accounts.add-transactions', ['account-head-id' => $candidate -> account_head_id, 'sr-no' => $candidate -> sr_no]) }}"
               class="btn btn-warning btn-sm" target="_blank">
                Add Payment
            </a>
        </div>
    </div>
    
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-secondary">
                <th class="text-dark">Sr.No</th>
                <th class="text-dark">Payment Date</th>
                <th class="text-dark">Voucher</th>
                <th class="text-dark">Description</th>
                <th class="text-dark">Amount</th>
            </tr>
            </thead>
            <tbody>
            @php $netPayments = 0; @endphp
            @if(count ($transactions) > 0)
                @foreach($transactions as $transaction)
                    @php
                        $payment = $transaction -> credit + $transaction -> debit;
                        $netPayments += $payment;
                    @endphp
                    <tr>
                        <td>{{ $loop -> iteration }}</td>
                        <td>
                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date($transaction -> transaction_date) }}
                        </td>
                        <td>
                            <a target="_blank"
                               href="{{ route ( 'invoices.transaction', [ 'voucher-no' => $transaction[ 'voucher_no' ] ] ) }}">
                                {{ $transaction -> voucher_no }}
                            </a>
                        </td>
                        <td>
                            {{ $transaction -> description }}
                        </td>
                        <td>{{ number_format ($payment, 2) }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" align="right">
                    <strong>Balance</strong>
                </td>
                <td>
                    @php
                        $balance = $professionFee ?-> fee - $netPayments;
                        $netAmount = $balance - $candidate -> discount;
                    @endphp
                    <strong>{{ number_format ($balance, 2) }}</strong>
                </td>
            </tr>
            @can('candidate_discount_flat', \App\Models\Candidate::class)
                <tr>
                    <td colspan="4" align="right">
                        <strong>Discount (Flat)</strong> <br/>
                        <p class="text-danger fw-bold">Discount enteries are not going into GL.</p>
                    </td>
                    <td>
                        <form method="post"
                              action="{{ route ('candidates.update-discount', ['candidate' => $candidate -> id]) }}">
                            @csrf
                            <label class="w-50">
                                <input type="number" name="discount" class="form-control" required="required" min="0"
                                       max="{{ $balance }}"
                                       value="{{ old ('discount', $candidate -> discount) }}">
                            </label>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </td>
                </tr>
            @endcan
            <tr>
                <td colspan="4" align="right">
                    <strong>Net Amount</strong>
                </td>
                <td>
                    <strong>{{ number_format($netAmount, 2) }}</strong>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <form method="post" action="{{ route ('save-payment-remarks', ['candidate' => $candidate -> id]) }}"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-3 mt-3">
                <label class="form-label" for="payment-remarks">
                    <strong>Payment Remarks</strong>
                </label>
                <textarea name="payment-remarks" class="form-control"
                          id="payment-remarks"
                          rows="5">{{ old ('payment-remarks', $candidate -> payment_remarks) }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3 mt-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="payment-slip-1">
                        <strong>Payment Slip# 1</strong>
                    </label>
                    @if($candidate -> payment_receipt && !empty(trim ($candidate -> payment_receipt -> receipt_1)))
                        <div>
                            <a href="{{ $candidate -> payment_receipt -> receipt_1 }}"
                               download="{{ $candidate -> fullName() }} - Payment Receipt - 1" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> payment_receipt -> receipt_1 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="payment-slip-1" class="form-control">
            </div>
            
            <div class="col-md-3 mb-3 mt-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="payment-slip-2">
                        <strong>Payment Slip# 2</strong>
                    </label>
                    @if($candidate -> payment_receipt && !empty(trim ($candidate -> payment_receipt -> receipt_2)))
                        <div>
                            <a href="{{ $candidate -> payment_receipt -> receipt_2 }}"
                               download="{{ $candidate -> fullName() }} - Payment Receipt - 2" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> payment_receipt -> receipt_2 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="payment-slip-2" class="form-control">
            </div>
            
            <div class="col-md-3 mb-3 mt-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="payment-slip-3">
                        <strong>Payment Slip# 3</strong>
                    </label>
                    @if($candidate -> payment_receipt && !empty(trim ($candidate -> payment_receipt -> receipt_3)))
                        <div>
                            <a href="{{ $candidate -> payment_receipt -> receipt_3 }}"
                               download="{{ $candidate -> fullName() }} - Payment Receipt - 3" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> payment_receipt -> receipt_3 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="payment-slip-3" class="form-control">
            </div>
            
            <div class="col-md-3 mb-3 mt-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="payment-slip-4">
                        <strong>Payment Slip# 4</strong>
                    </label>
                    @if($candidate -> payment_receipt && !empty(trim ($candidate -> payment_receipt -> receipt_4)))
                        <div>
                            <a href="{{ $candidate -> payment_receipt -> receipt_4 }}"
                               download="{{ $candidate -> fullName() }} - Payment Receipt - 4" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> payment_receipt -> receipt_4 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="payment-slip-4" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>