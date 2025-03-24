<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('users.update', ['user' => $user -> id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input
                                                    type="text" required="required" autofocus="autofocus"
                                                    class="form-control" value="{{ old ('name', $user -> name) }}"
                                                    id="name"
                                                    name="name" />
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="add-user-email">Email</label>
                                            <input
                                                    type="text" required="required"
                                                    id="add-user-email" value="{{ old ('email', $user -> email) }}"
                                                    class="form-control"
                                                    name="email" />
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input
                                                    type="password"
                                                    id="password"
                                                    class="form-control"
                                                    name="password" />
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="cnic">CNIC</label>
                                            <input type="text" id="cnic" class="form-control" name="cnic"
                                                   value="{{ old ('cnic', $user -> cnic) }}" />
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="mobile">Mobile No</label>
                                            <input type="text" id="mobile" class="form-control" name="mobile"
                                                   value="{{ old ('mobile', $user -> mobile) }}" />
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="roles">Role(s)</label>
                                            <select id="roles" name="roles[]" multiple="multiple"
                                                    class="form-control select2" required="required"
                                                    data-placeholder="Select">
                                                <option></option>
                                                @if(count ($roles) > 0)
                                                    @foreach($roles as $key => $role)
                                                        <option value="{{ $role -> id }}" @selected(in_array ($role -> id, $user -> roles()))>
                                                            {{ $role -> title }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea id="address" class="form-control" name="address"
                                                      rows="3">{{ old ('address', $user -> address) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="align-items-center border d-flex flex-column gap-4 justify-content-center pt-3 rounded">
                                            <img src="{{ $user -> image() }}"
                                                 alt="user-avatar"
                                                 class="d-block w-100 rounded" id="uploadedAvatar" />
                                            <div class="align-items-center button-wrapper w-100 d-flex flex-column justify-content-center">
                                                <label for="upload" class="btn btn-primary d-block w-100 mb-3"
                                                       tabindex="0">
                                                    <span class="d-none d-sm-block w-100">Upload</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" name="file" id="upload"
                                                           class="account-file-input"
                                                           hidden="hidden"
                                                           accept="image/png, image/jpg, image/jpeg" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $ ( window ).on ( 'load', function () {
                $ ( document ).on ( 'change', '.account-file-input', function () {
                    let accountUserImage = document.getElementById ( 'uploadedAvatar' );
                    if ( accountUserImage ) {
                        const resetImage = accountUserImage.src;
                        if ( this.files[ 0 ] ) {
                            accountUserImage.src = window.URL.createObjectURL ( this.files[ 0 ] );
                        }
                    }
                } );
            } );
        </script>
    @endpush
</x-dashboard>