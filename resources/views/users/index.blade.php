<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Session</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2">21,459</h3>
                                    <p class="text-success mb-0">(+29%)</p>
                                </div>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="avatar">
                          <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-user ti-sm"></i>
                          </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Paid Users</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2">4,567</h3>
                                    <p class="text-success mb-0">(+18%)</p>
                                </div>
                                <p class="mb-0">Last week analytics</p>
                            </div>
                            <div class="avatar">
                          <span class="avatar-initial rounded bg-label-danger">
                            <i class="ti ti-user-plus ti-sm"></i>
                          </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Active Users</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2">19,860</h3>
                                    <p class="text-danger mb-0">(-14%)</p>
                                </div>
                                <p class="mb-0">Last week analytics</p>
                            </div>
                            <div class="avatar">
                          <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-user-check ti-sm"></i>
                          </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Pending Users</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2">237</h3>
                                    <p class="text-success mb-0">(+42%)</p>
                                </div>
                                <p class="mb-0">Last week analytics</p>
                            </div>
                            <div class="avatar">
                          <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-user-exclamation ti-sm"></i>
                          </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($users) > 0)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $user -> fullName() }}</td>
                                <td>{{ $user -> email }}</td>
                                <td>
                                    @if($user -> active == '1')
                                        <span class="badge rounded-pill bg-label-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $user)
                                            <a href="{{ route ('users.edit', ['user' => $user -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('status', $user)
                                            <a href="{{ route ('users.status', ['user' => $user -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top" onclick="return confirm('Are you sure?')"
                                               data-bs-custom-class="tooltip-warning"
                                               title="Change Status">
                                                <i class="ti ti-status-change ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $user)
                                            <form method="post" id="delete-record-form-{{ $user -> id }}"
                                                  action="{{ route ('users.destroy', ['user' => $user -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $user -> id }})">
                                                    <i class="ti ti-trash ti-sm mx-2"></i>
                                                </button>
                                            </form>
                                        @endcan
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
            init_datatable ( '{{ route ('users.create') }}' )
        </script>
    @endpush
</x-dashboard>