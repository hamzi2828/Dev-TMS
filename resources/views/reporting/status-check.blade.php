<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('reporting.search')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('Status Check')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" style="vertical-align: top" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Sr. No</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Referral</th>
                        <th>Interview</th>
                        <th>Medical</th>
                        <th>Document Ready</th>
                        <th>Documents Uploaded</th>
                        <th>Visa</th>
                        <th>Protector</th>
                        <th>Ticket</th>
                        <th>BackOut</th>
                        <th>Agreed Payment</th>
                        <th>Payments Submitted</th>
                        <th>Balance</th>
                        <th>Payment Remarks</th>
                        <th>Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    <a href="{{ route ('candidates.edit', ['candidate' => $candidate -> id]) }}">
                                        {{ $candidate -> SerialNo() }}
                                    </a>
                                </td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>{{ $candidate -> fullName() }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
                                <td>
                                    @if($candidate -> interview && !empty(trim ($candidate -> interview ?-> status)))
                                        @php
                                            $bg = 'primary';
                                            if ($candidate -> interview ?-> status === 'selected')
                                                $bg = 'success';
                                            else if ($candidate -> interview ?-> status === 'rejected')
                                                $bg = 'danger';
                                            else if ($candidate -> interview ?-> status === 'standby')
                                                $bg = 'warning';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> interview ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> interview ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> interview ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @if($candidate -> medical && !empty(trim ($candidate -> medical ?-> status)))
                                        @php
                                            $bg = 'warning';
                                            if ($candidate -> medical ?-> status == 'fit')
                                                $bg = 'success';
                                            if ($candidate -> medical ?-> status == 'unfit')
                                                $bg = 'danger';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> medical ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> medical ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> medical ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @if($candidate -> document_ready && !empty(trim ($candidate -> document_ready ?-> status)))
                                        @php
                                            $bg = 'warning';
                                            if ($candidate -> document_ready ?-> status == 'yes')
                                                $bg = 'success';
                                            if ($candidate -> document_ready ?-> status == 'no')
                                                $bg = 'danger';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> document_ready ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> document_ready ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> document_ready ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @php $bg = !empty(trim ($candidate -> visa ?-> tgid)) ? 'success' : 'warning'; @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> visa ?-> tgid)) ? 'Documents Uploaded' : 'No documents attached' }}
                                    </span>
                                </td>
                                <td>
                                    @if($candidate -> document_ready && !empty(trim ($candidate -> document_ready ?-> status)) && $candidate -> document_ready ?-> status == 'yes' && $candidate -> visa && !empty(trim ($candidate -> visa ?-> status)))
                                        @php
                                            $bg = 'primary';
                                            if ($candidate -> visa ?-> status === 'in-process')
                                                $bg = 'warning';
                                            else if ($candidate -> visa ?-> status === 'issued')
                                                $bg = 'success';
                                            else if ($candidate -> visa ?-> status === 'rejected')
                                                $bg = 'danger';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> visa ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> visa ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> visa ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @if($candidate -> protector && !empty(trim ($candidate -> protector ?-> status)))
                                        @php
                                            $bg = 'primary';
                                            if ($candidate -> protector ?-> status == 'sent')
                                                $bg = 'warning';
                                            else if ($candidate -> protector ?-> status == 'done')
                                                $bg = 'success';
                                            else if ($candidate -> protector ?-> status == 'hold')
                                                $bg = 'warning';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> protector ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> protector ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> protector ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td> 
                                <td>
                                    @if($candidate -> ticket && !empty(trim ($candidate -> ticket ?-> status)))
                                        @php
                                            $bg = 'primary';
                                            if ($candidate -> ticket ?-> status == 'sent')
                                                $bg = 'warning';
                                            else if ($candidate -> ticket ?-> status == 'done')
                                                $bg = 'success';
                                            else if ($candidate -> ticket ?-> status == 'hold')
                                                $bg = 'warning';
                                        @endphp
                                        <p class="mt-2 mb-1">
                                            <span class="badge bg-{{ $bg }}">
                                                {{ str () -> title ($candidate -> ticket ?-> status) }} <br />
                                            </span>
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> ticket ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> ticket ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @php $bg = $candidate -> back_out ? 'danger' : 'success'; @endphp
                                    <p class="mt-2 mb-1">
                                        <span class="badge bg-{{ $bg }}">
                                            {{ $candidate -> back_out ? 'Yes' : 'No' }} <br />
                                        </span>
                                    </p>
                                </td>
                                <td>{{ number_format ($candidate -> job ?-> fee, 2) }}</td>
                                <td>
                                    @php $netPayments = 0; @endphp
                                    @if(count ($candidate -> transactions) > 0)
                                        @foreach($candidate -> transactions as $transaction)
                                            @php
                                                $payment = $transaction -> credit + $transaction -> debit;
                                                $netPayments += $payment;
                                            @endphp
                                        @endforeach
                                    @endif
                                    {{ number_format ($netPayments, 2) }}
                                </td>
                                <td>{{ number_format (($candidate -> job ?-> fee - $netPayments), 2) }}</td>
                                <td>{{ $candidate -> payment_remarks }}</td>
                                <td>{{ $candidate -> createdAt() }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>