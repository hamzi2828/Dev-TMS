<x-dashboard :title="$title">
    @push('styles')
        <style>
            .ck-editor__editable_inline {
                min-height : 280px;
            }
        </style>
    @endpush
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('agreements.store') }}">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="job-id">Profession</label>
                                    <select name="job-id" class="form-control select2" data-placeholder="Select"
                                            required="required" id="job-id">
                                        <option></option>
                                        @if(count ($jobs) > 0)
                                            @foreach($jobs as $job)
                                                <option value="{{ $job -> id }}"
                                                        @selected(old ('job-id') == $job -> id)>
                                                    {{ $job -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="principal-id">Principal</label>
                                    <select name="principal-id" class="form-control select2" data-placeholder="Select"
                                            required="required" id="principal-id">
                                        <option></option>
                                        @if(count ($principals) > 0)
                                            @foreach($principals as $principal)
                                                <option value="{{ $principal -> id }}"
                                                        @selected(old ('principal-id') == $principal -> id)>
                                                    {{ $principal -> name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title') }}"
                                           id="title" name="title" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label w-100" for="editor">
                                    <textarea name="template" id="editor" cols="30"
                                              rows="10">{{ old ('template') }}</textarea>
                                    </label>
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
        <script src="{{ asset ('/assets/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            ClassicEditor
                .create ( document.querySelector ( '#editor' ), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'insertTable', 'blockQuote', 'bulletedList', 'numberedList' ]
                } )
                .then ( editor => {
                    window.editor = editor;
                } )
                .catch ( err => {
                
                } );
        </script>
    @endpush
</x-dashboard>