<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Bank Name</th>
                            <th>Bank Logo</th>
                            <th>Branch Code</th>
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
                                        <a href="{{ route ('banks.edit', ['bank' => $bank -> id]) }}"
                                            class="text-body" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-custom-class="tooltip-primary"
                                            title="Edit">
                                             <i class="ti ti-edit ti-sm me-2"></i>
                                         </a>
                                         <form method="post" id="delete-record-form-{{ $bank -> id }}"
                                            action="{{ route ('banks.destroy', ['bank' => $bank -> id]) }}">
                                          @method('DELETE')
                                          @csrf
                                          <button type="button" data-bs-toggle="tooltip"
                                                  data-bs-placement="top"
                                                  data-bs-custom-class="tooltip-danger"
                                                  title="Delete"
                                                  class="text-body delete-record bg-transparent border-0 p-0"
                                                  onclick="delete_confirmation({{ $bank -> id }})">
                                              <i class="ti ti-trash ti-sm mx-2"></i>
                                          </button>
                                      </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('banks.create') }}' )
        </script>
    @endpush
</x-dashboard>
