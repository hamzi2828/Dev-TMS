<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('data-banks.update', ['data_bank' => $data_bank -> id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="job-id">
                                        Position Applied For
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <select name="job-id" class="form-control select2" data-placeholder="Select"
                                            required="required" id="job-id">
                                        <option></option>
                                        @if(count ($jobs) > 0)
                                            @foreach($jobs as $job)
                                                <option value="{{ $job -> id }}"
                                                        @selected(old ('job-id', $data_bank -> job_id) == $job -> id)>
                                                    {{ $job -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="country-id">Nationality</label>
                                    <select name="country-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="country-id"
                                            onchange="load_cities_by_country(this.value, '{{ route ('countries.cities') }}')">
                                        <option></option>
                                        @if(count ($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{ $country -> id }}"
                                                        @selected(old ('country-id', $data_bank -> country_id) == $country -> id)>
                                                    {{ $country -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="city">Place of Birth</label>
                                    <select name="city-id" id="city" class="form-control select2"
                                            data-placeholder="Select"
                                            data-allow-clear="true">
                                        <option></option>
                                        @if(count ($cities) > 0)
                                            @foreach($cities as $city)
                                                <option value="{{ $city -> id }}"
                                                        @selected(old ('city-id', $data_bank -> city_id) == $city -> id)>
                                                    {{ $city -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="qualification-id">Qualification</label>
                                    <select name="qualification-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="qualification-id">
                                        <option></option>
                                        @if(count ($qualifications) > 0)
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification -> id }}"
                                                        @selected(old ('qualification-id', $data_bank -> qualification_id) == $qualification -> id)>
                                                    {{ $qualification -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="first-name">
                                        First Name
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="first-name" class="form-control" required="required"
                                           id="first-name" oninput="validateInput(this)"
                                           value="{{ old ('first-name', $data_bank -> first_name) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="last-name">
                                        Last Name
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="last-name" class="form-control" required="required"
                                           id="last-name" oninput="validateInput(this)"
                                           value="{{ old ('last-name', $data_bank -> last_name) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="father-name">Father Name</label>
                                    <input type="text" name="father-name" class="form-control" id="father-name"
                                           value="{{ old ('father-name', $data_bank -> father_name) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="mother-name">Mother Name</label>
                                    <input type="text" name="mother-name" class="form-control" id="mother-name"
                                           value="{{ old ('mother-name', $data_bank -> mother_name) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="mobile">
                                        Mobile No
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="number" name="mobile" class="form-control" id="mobile"
                                           required="required"
                                           value="{{ old ('mobile', $data_bank -> mobile) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="alt-no">Alternate No</label>
                                    <input type="number" name="alt-no" class="form-control" id="alt-no"
                                           value="{{ old ('alt-no', $data_bank -> alt_no) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic">
                                        CNIC
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="number" name="cnic" class="form-control" id="cnic" required="required"
                                           minlength="13" maxlength="13"
                                           value="{{ old ('cnic', $data_bank -> cnic) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic-expiry-date">CNIC Expiry Date</label>
                                    <input type="text" name="cnic-expiry-date" class="form-control flatpickr-basic"
                                           id="cnic-expiry-date" required="required"
                                           value="{{ old ('cnic-expiry-date', $data_bank -> cnic_expiry_date) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="dob">
                                        Date of Birth
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="dob" class="form-control flatpickr-basic"
                                           id="dob" required="required" onchange="calculateAge(this.value)"
                                           value="{{ old ('dob', $data_bank -> dob) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport">Passport No</label>
                                    <input type="text" name="passport" class="form-control" id="passport"
                                           value="{{ old ('passport', $data_bank -> passport) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport-issue-date">Passport Issue Date</label>
                                    <input type="text" name="passport-issue-date" class="form-control flatpickr-basic"
                                           id="passport-issue-date"
                                           value="{{ old ('passport-issue-date', $data_bank -> passport_issue_date) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport-expiry-date">Passport Expiry Date</label>
                                    <input type="text" name="passport-expiry-date" class="form-control flatpickr-basic"
                                           id="passport-expiry-date"
                                           value="{{ old ('passport-expiry-date', $data_bank -> passport_expiry_date) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="issue-country-id">Place of Issue</label>
                                    <select name="issue-country-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="issue-country-id">
                                        <option></option>
                                        @if(count ($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{ $country -> id }}"
                                                        @selected(old ('issue-country-id', $data_bank -> passport_issue_country_id ) == $country -> id)>
                                                    {{ $country -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="religion">Religion</label>
                                    <select name="religion" class="form-control select2"
                                            data-placeholder="Select"
                                            id="religion">
                                        <option></option>
                                        <option value="muslim" @selected(old ('religion', $data_bank -> religion) == 'muslim')>
                                            Muslim
                                        </option>
                                        <option value="christan" @selected(old ('religion', $data_bank -> religion) == 'christan')>
                                            Christan
                                        </option>
                                        <option value="hindu" @selected(old ('religion', $data_bank -> religion) == 'hindu')>
                                            Hindu
                                        </option>
                                        <option value="sikh" @selected(old ('religion', $data_bank -> religion) == 'sikh')>
                                            Sikh
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="marital-status">Marital Status</label>
                                    <select name="marital-status" class="form-control select2"
                                            data-placeholder="Select"
                                            id="marital-status">
                                        <option></option>
                                        <option value="single" @selected(old ('marital-status', $data_bank -> marital_status) == 'single')>
                                            Single
                                        </option>
                                        <option value="married" @selected(old ('marital-status', $data_bank -> marital_status) == 'married')>
                                            Married
                                        </option>
                                        <option value="divorced" @selected(old ('marital-status', $data_bank -> marital_status) == 'divorced')>
                                            Divorced
                                        </option>
                                        <option value="widow" @selected(old ('marital-status', $data_bank -> marital_status) == 'widow')>
                                            Widow
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="age">Age (Years)</label>
                                    <input type="number" name="age" class="form-control" id="age"
                                           value="{{ old ('age', $data_bank -> age) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select name="gender" class="form-control select2"
                                            data-placeholder="Select"
                                            id="gender">
                                        <option></option>
                                        <option value="male" @selected(old ('gender', $data_bank -> gender) == 'male')>
                                            Male
                                        </option>
                                        <option value="female" @selected(old ('gender', $data_bank -> gender) == 'female')>
                                            Female
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="blood-group">Blood Group</label>
                                    <select name="blood-group" class="form-control select2"
                                            data-placeholder="Select"
                                            id="blood-group">
                                        <option></option>
                                        <option value="A-" @selected(old ('blood-group', $data_bank -> blood_group) == 'A-')>
                                            A-
                                        </option>
                                        <option value="A+" @selected(old ('blood-group', $data_bank -> blood_group) == 'A+')>
                                            A+
                                        </option>
                                        <option value="B-" @selected(old ('blood-group', $data_bank -> blood_group) == 'B-')>
                                            B-
                                        </option>
                                        <option value="B+" @selected(old ('blood-group', $data_bank -> blood_group) == 'B+')>
                                            B+
                                        </option>
                                        <option value="AB-" @selected(old ('blood-group', $data_bank -> blood_group) == 'AB-')>
                                            AB-
                                        </option>
                                        <option value="AB+" @selected(old ('blood-group', $data_bank -> blood_group) == 'AB+')>
                                            AB+
                                        </option>
                                        <option value="O-" @selected(old ('blood-group', $data_bank -> blood_group) == 'O-')>
                                            O-
                                        </option>
                                        <option value="O+" @selected(old ('blood-group', $data_bank -> blood_group) == 'O+')>
                                            O+
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="lead-source-id">Source</label>
                                    <select name="lead-source-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="lead-source-id">
                                        <option></option>
                                        @if(count ($sources) > 0)
                                            @foreach($sources as $source)
                                                <option value="{{ $source -> id }}"
                                                        @selected(old ('lead-source-id', $data_bank -> lead_source_id) == $source -> id)>
                                                    {{ $source -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="province-id">Province</label>
                                    <select name="province-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="province-id">
                                        <option></option>
                                        @if(count ($provinces) > 0)
                                            @foreach($provinces as $province)
                                                <option value="{{ $province -> id }}"
                                                        @selected(old ('province-id', $data_bank -> province_id) == $province -> id)>
                                                    {{ $province -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="district-id">District</label>
                                    <select name="district-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="district-id">
                                        <option></option>
                                        @if(count ($districts) > 0)
                                            @foreach($districts as $district)
                                                <option value="{{ $district -> id }}"
                                                        @selected(old ('district-id', $data_bank -> district_id) == $district -> id)>
                                                    {{ $district -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="referral">
                                        Referral
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <select name="referral-id" class="form-control select2"
                                            data-placeholder="Select" required="required"
                                            id="referral">
                                        <option></option>
                                        @if(count ($referrals) > 0)
                                            @foreach($referrals as $referral)
                                                <option value="{{ $referral -> id }}"
                                                        @selected(old ('referral-id', $data_bank -> referral_id) == $referral -> id)>
                                                    {{ $referral -> name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           id="address"
                                           value="{{ old ('address', $data_bank -> address) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <h4 class="bg-dark text-white pt-1 pb-1 fw-semibold">Other Information</h4>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="next-of-kin">Next of Kin</label>
                                    <input type="text" name="next-of-kin" class="form-control" id="next-of-kin"
                                           oninput="validateInput(this)"
                                           value="{{ old ('next-of-kin', $data_bank -> next_of_kin) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="next-of-kin-cnic">
                                        Next of Kin CNIC
                                    </label>
                                    <input type="number" name="next-of-kin-cnic" class="form-control"
                                           id="next-of-kin-cnic"
                                           minlength="13" maxlength="13"
                                           value="{{ old ('next-of-kin-cnic', $data_bank -> next_of_cnic) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="kin-relationship">Kin Relationship</label>
                                    <input type="text" name="kin-relationship" class="form-control"
                                           oninput="validateInput(this)"
                                           id="kin-relationship"
                                           value="{{ old ('kin-relationship', $data_bank -> kin_relationship) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact-no">Kin Contact No</label>
                                    <input type="number" name="contact-no" class="form-control" id="contact-no"
                                           value="{{ old ('contact-no', $data_bank -> contact_no) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="shirt-size">Shirt Size</label>
                                    <select name="shirt-size" class="form-control select2" id="shirt-size"
                                            data-placeholder="Select">
                                        <option></option>
                                        <option value="small" @selected(old ('shirt-size', $data_bank -> shirt_size) == 'small')>
                                            Small
                                        </option>
                                        <option value="medium" @selected(old ('shirt-size', $data_bank -> shirt_size) == 'medium')>
                                            Medium
                                        </option>
                                        <option value="large" @selected(old ('shirt-size', $data_bank -> shirt_size) == 'large')>
                                            Large
                                        </option>
                                        <option value="xl" @selected(old ('shirt-size', $data_bank -> shirt_size) == 'xl')>
                                            XL
                                        </option>
                                        <option value="xxl" @selected(old ('shirt-size', $data_bank -> shirt_size) == 'xxl')>
                                            XXL
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="trouser-size">Trouser Size</label>
                                    <select name="trouser-size" class="form-control select2" id="trouser-size"
                                            data-placeholder="Select">
                                        <option></option>
                                        @for($trouser = 28; $trouser <= 44; $trouser+=2)
                                            <option value="{{ $trouser }}" @selected(old ('trouser-size', $data_bank -> trouser_size) == $trouser)>
                                                {{ $trouser }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="shoes-size">Shoes Size</label>
                                    <select name="shoes-size" class="form-control select2" id="shoes-size"
                                            data-placeholder="Select">
                                        <option></option>
                                        @for($shoes = 36; $shoes <= 44; $shoes++)
                                            <option value="{{ $shoes }}" @selected(old ('shoes-size', $data_bank -> shoes_size) == $shoes)>
                                                {{ $shoes }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="weight">Weight (kg)</label>
                                    <input type="number" step="0.01" name="weight" class="form-control" id="weight"
                                           value="{{ old ('weight', $data_bank -> weight) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="height">Height (cm)</label>
                                    <input type="number" step="0.01" name="height" class="form-control" id="height"
                                           value="{{ old ('height', $data_bank -> height) }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           value="{{ old ('email', $data_bank -> email) }}">
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
</x-dashboard>