<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('accounts.update', ['account' => $account -> id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-3 mb-3">
                                    <label class="form-label"
                                           for="account-heads">Account Head</label>
                                    <select name="account-head-id" class="form-control chosen-select" id="account-heads"
                                            data-placeholder="Select">
                                        <option></option>
                                        {!! $list !!}
                                    </select>
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="form-label"
                                           for="account-type">Account Type</label>
                                    <select name="account-type-id" class="form-control chosen-select" id="account-type"
                                            data-placeholder="Select">
                                        <option></option>
                                        @if(count ($types) > 0)
                                            @foreach($types as $type)
                                                <option value="{{ $type -> id }}" @selected(old ('account-type-id', $account -> account_type_id) == $type -> id)>
                                                    {{ $type -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name"
                                           required="required" autofocus="autofocus"
                                           name="name" placeholder="Name"
                                           value="{{ old ('name', $account -> name) }}" />
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="form-label" for="phone">Phone No</label>
                                    <input type="text" class="form-control" id="phone"
                                           name="phone" placeholder="Phone No"
                                           value="{{ old ('phone', $account -> phone) }}" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" rows="5" id="description"
                                              class="form-control">{{ old ('description', $account -> description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-1">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>