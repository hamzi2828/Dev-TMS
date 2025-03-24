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
                                        <a href="{{ route ('users.restore', ['user_id' => $user -> id]) }}"
                                           onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="tooltip-success"
                                           title="Restore"
                                           class="text-body">
                                            <i class="ti ti-recycle ti-sm me-2"></i>
                                        </a>
                                        
                                        <form method="post" id="delete-record-form-{{ $user -> id }}"
                                              action="{{ route ('users.force-delete', ['user_id' => $user -> id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-custom-class="tooltip-danger"
                                                    title="Delete Permanently"
                                                    class="text-body delete-record bg-transparent border-0 p-0"
                                                    onclick="delete_confirmation({{ $user -> id }})">
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
            init_datatable ( '{{ route ('users.create') }}' )
        </script>
    @endpush
</x-dashboard>