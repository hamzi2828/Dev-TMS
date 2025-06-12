<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')


        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('My Booking List')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Bank Name</th>
                            <th>Bank Logo</th>
                            <th>Bank Code</th>
                            <th>Bank Branch</th>
                            <th>Account Title</th>
                            <th>Account Number</th>
                            <th>IBAN</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank->bank_name }}</td>
                                <td>
                                    @if(!empty(trim ($bank->file)))
                                        <img src="{{ $bank->file }}" alt="Bank Logo" width="70" height="30">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {{ $bank->bank_code }}
                                </td>
                                <td>
                                    {{ $bank->bank_branch }}
                                </td>
                                <td>
                                    {{ $bank->account_title }}
                                </td>
                                <td>
                                    {{ $bank->account_number }}
                                </td>
                                <td>
                                    {{ $bank->iban }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" style="min-width: 100px">
                                        <a href="{{ route('myBookings.editBank', ['bank' => $bank->id]) }}"
                                           class="btn btn-primary btn-sm"
                                           title="Edit">
                                            Edit
                                        </a>
                                        <form action="{{ route('myBookings.destroyBank', ['bank' => $bank->id]) }}"
                                              method="post" class="ms-2"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(method_exists($banks, 'links'))
                {{ $banks->onEachSide(5)->links('pagination::bootstrap-5') }}
            @endif

        </div>

    </div>
    <!-- / Content -->

    @push('scripts')
        <script type="text/javascript">
            init_datatable('{{ route('myBookings.createBank') }}');
        </script>
    @endpush
</x-dashboard>
