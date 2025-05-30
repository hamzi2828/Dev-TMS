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
                        <th>Sr.No</th>
                        <th>Added By</th>
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Landline</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($companies) > 0)
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    @if($company -> user_id > 0)
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ $lead -> user ?-> image() }}" alt="Avatar"
                                                         class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column user-info">
                                                <a href="{{ route ('users.edit', ['user' => $company -> user_id]) }}"
                                                   class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $company -> user ?-> name }}</span>
                                                </a>
                                                <small class="text-muted">{{ $company -> user ?-> email }}</small>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $company -> fullName() }}</td>
                                <td>{{ $company -> manager ?-> fullName() }}</td>
                                <td>{{ $company -> landline }}</td>
                                <td>{{ $company -> mobile }}</td>
                                <td>
                                    @if($company -> active == '1')
                                        <span class="badge rounded-pill bg-label-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $company -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route ('companies.restore', ['company_id' => $company -> id]) }}"
                                           onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="tooltip-success"
                                           title="Restore"
                                           class="text-body">
                                            <i class="ti ti-recycle ti-sm me-2"></i>
                                        </a>
                                        
                                        <form method="post" id="delete-record-form-{{ $company -> id }}"
                                              action="{{ route ('companies.force-delete', ['company_id' => $company -> id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-custom-class="tooltip-danger"
                                                    title="Delete Permanently"
                                                    class="text-body delete-record bg-transparent border-0 p-0"
                                                    onclick="delete_confirmation({{ $company -> id }})">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('companies.create') }}' )
        </script>
    @endpush
</x-dashboard>