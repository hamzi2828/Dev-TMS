<form class="pt-0" method="post"
      action="{{ route ('candidates.update', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body pt-1 pb-1">
        <div class="row border-bottom mb-4">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="payment-method">
                    Payment Method
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="payment-method" class="form-control select2"
                        data-placeholder="Select" disabled="disabled"
                        required="required" id="payment-method">
                    <option></option>
                    @if(count ($payment_methods) > 0)
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method -> id }}"
                                    @selected(old ('payment-method', $candidate -> payment_method_id) == $payment_method -> id)>
                                {{ $payment_method -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="transaction-no">
                    Transaction No
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="text" required="required" class="form-control"
                       {{ $candidate -> free_candidate == '1' ? 'disabled="disabled"' : '' }}
                       value="{{ old ('transaction-no', $candidate -> transaction_no) }}"
                       autofocus="autofocus" {{ auth () -> user () -> is_admin() ? '' : 'readonly="readonly"' }}
                       id="transaction-no" name="transaction-no" />
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="referral">
                    Referral
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="referral-id" class="form-control select2" required="required"
                        {{ ($candidate -> referral_id > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        data-placeholder="Select" id="referral">
                    <option></option>
                    @if(count ($referrals) > 0)
                        @foreach($referrals as $referral)
                            <option value="{{ $referral -> id }}"
                                    @selected(old ('referral-id', $candidate -> referral_id) == $referral -> id)>
                                {{ $referral -> name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="principal">
                    Principal
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="principal-id" class="form-control select2"
                        data-placeholder="Select" required="required"
                        {{ ($candidate -> principal_id > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        id="principal">
                    <option></option>
                    @if(count ($principals) > 0)
                        @foreach($principals as $principal)
                            <option value="{{ $principal -> id }}"
                                    @selected(old ('principal-id', $candidate -> principal_id) == $principal -> id)>
                                {{ $principal -> name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        
        <div class="row">
            <h4 class="bg-dark text-white pt-1 pb-1 fw-semibold">Personal Information</h4>
        </div>
        
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
                                    @selected(old ('job-id', $candidate -> job_id) == $job -> id)>
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
                                    @selected(old ('country-id', $candidate -> country_id) == $country -> id)>
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
                                    @selected(old ('city-id', $candidate -> city_id) == $city -> id)>
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
                                    @selected(old ('qualification-id', $candidate -> qualification_id) == $qualification -> id)>
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
                       id="first-name"
                       value="{{ old ('first-name', $candidate -> first_name) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="last-name">Last Name</label>
                <input type="text" name="last-name" class="form-control"
                       id="last-name"
                       value="{{ old ('last-name', $candidate -> last_name) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="father-name">
                    Father Name
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="text" name="father-name" class="form-control" id="father-name" required="required"
                       value="{{ old ('father-name', $candidate -> father_name) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="mother-name">Mother Name</label>
                <input type="text" name="mother-name" class="form-control" id="mother-name"
                       value="{{ old ('mother-name', $candidate -> mother_name) }}">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="mobile">
                    Mobile No
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="text" name="mobile" class="form-control" id="mobile" required="required"
                       value="{{ old ('mobile', $candidate -> mobile) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="alt-no">Alternate No</label>
                <input type="text" name="alt-no" class="form-control" id="alt-no"
                       value="{{ old ('alt-no', $candidate -> alt_no) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="cnic">
                    CNIC
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="number" name="cnic" class="form-control" id="cnic" required="required" minlength="13"
                       maxlength="13"
                       value="{{ old ('cnic', $candidate -> cnic) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="cnic-expiry-date">CNIC Expiry Date</label>
                <input type="text" name="cnic-expiry-date" class="form-control flatpickr-basic"
                       id="cnic-expiry-date"
                       value="{{ old ('cnic-expiry-date', $candidate -> cnic_expiry) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="dob">
                    Date of Birth
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <input type="text" name="dob" class="form-control flatpickr-basic"
                       id="dob" required="required" onchange="calculateAge(this.value)"
                       value="{{ old ('dob', $candidate -> dob) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="passport">Passport No</label>
                <input type="text" name="passport" class="form-control" id="passport"
                       value="{{ old ('passport', $candidate -> passport) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="passport-issue-date">Passport Issue Date</label>
                <input type="text" name="passport-issue-date" class="form-control flatpickr-basic"
                       id="passport-issue-date"
                       value="{{ old ('passport-issue-date', $candidate -> passport_issue_date) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="passport-expiry-date">Passport Expiry Date</label>
                <input type="text" name="passport-expiry-date" class="form-control flatpickr-basic"
                       id="passport-expiry-date"
                       value="{{ old ('passport-expiry-date', $candidate -> passport_expiry_date) }}">
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
                                    @selected(old ('issue-country-id', $candidate -> passport_issue_country_id) == $country -> id)>
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
                    <option value="muslim" @selected(old ('religion', $candidate -> religion) == 'muslim')>
                        Muslim
                    </option>
                    <option value="christan" @selected(old ('religion', $candidate -> religion) == 'christan')>
                        Christan
                    </option>
                    <option value="hindu" @selected(old ('religion', $candidate -> religion) == 'hindu')>
                        Hindu
                    </option>
                    <option value="sikh" @selected(old ('religion', $candidate -> religion) == 'sikh')>
                        Sikh
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="sect">Sect</label>
                <select name="sect" class="form-control select2"
                        data-placeholder="Select"
                        id="sect">
                    <option value="sunni" @selected(old ('sect', $candidate -> sect) == 'sunni')>Sunni</option>
                    <option value="shia" @selected(old ('sect', $candidate -> sect) == 'shia')>Shia</option>
                    <option value="whabbi" @selected(old ('sect', $candidate -> sect) == 'whabbi')>Whabbi</option>
                    <option value="salafi" @selected(old ('sect', $candidate -> sect) == 'salafi')>Salafi</option>
                    <option value="berelvi" @selected(old ('sect', $candidate -> sect) == 'berelvi')>Berelvi</option>
                    <option value="sufi" @selected(old ('sect', $candidate -> sect) == 'sufi')>Sufi</option>
                    <option value="deobandi" @selected(old ('sect', $candidate -> sect) == 'deobandi')>Deobandi</option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="marital-status">Marital Status</label>
                <select name="marital-status" class="form-control select2"
                        data-placeholder="Select"
                        id="marital-status">
                    <option></option>
                    <option value="single" @selected(old ('marital-status', $candidate -> marital_status) == 'single')>
                        Single
                    </option>
                    <option value="married" @selected(old ('marital-status', $candidate -> marital_status) == 'married')>
                        Married
                    </option>
                    <option value="divorced" @selected(old ('marital-status', $candidate -> marital_status) == 'divorced')>
                        Divorced
                    </option>
                    <option value="widow" @selected(old ('marital-status', $candidate -> marital_status) == 'widow')>
                        Widow
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="age">Age (Years)</label>
                <input type="number" name="age" class="form-control" id="age"
                       value="{{ old ('age', $candidate -> age) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="gender">Gender</label>
                <select name="gender" class="form-control select2"
                        data-placeholder="Select"
                        id="gender">
                    <option></option>
                    <option value="male" @selected(old ('gender', $candidate -> gender) == 'male')>
                        Male
                    </option>
                    <option value="female" @selected(old ('gender', $candidate -> gender) == 'female')>
                        Female
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="contract-period">Period of contract (Years)</label>
                <input type="number" name="contract-period" class="form-control"
                       id="contract-period"
                       value="{{ old ('contract-period', $candidate -> contract_period) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="accommodation">Accommodation</label>
                <select name="accommodation" class="form-control select2"
                        data-placeholder="Select"
                        id="accommodation">
                    <option></option>
                    <option value="free" @selected(old ('accommodation', $candidate -> accommodation) == 'free')>Free
                    </option>
                    <option value="not-free" @selected(old ('accommodation', $candidate -> accommodation) == 'not-free')>
                        Not Free
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="food">Food</label>
                <select name="food" class="form-control select2"
                        data-placeholder="Select"
                        id="food">
                    <option></option>
                    <option value="free" @selected(old ('food', $candidate -> food) == 'free')>Free</option>
                    <option value="not-free" @selected(old ('food', $candidate -> food) == 'not-free')>
                        Not Free
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="salary">Salary</label>
                <input type="number" name="salary" class="form-control"
                       id="salary"
                       value="{{ old ('salary', $candidate -> salary) }}">
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
                                    @selected(old ('lead-source-id', $candidate -> lead_source_id) == $source -> id)>
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
                                    @selected(old ('province-id', $candidate -> province_id) == $province -> id)>
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
                                    @selected(old ('district-id', $candidate -> district_id) == $district -> id)>
                                {{ $district -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-12 mb-3">
                <label class="form-label" for="address">Address</label>
                <input type="text" name="address" class="form-control"
                       id="address"
                       value="{{ old ('address', $candidate -> address) }}">
            </div>
        </div>
        
        <div class="row">
            <h4 class="bg-dark text-white pt-1 pb-1 fw-semibold">Other Information</h4>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="next-of-kin">Next of Kin</label>
                <input type="text" name="next-of-kin" class="form-control" id="next-of-kin"
                       value="{{ old ('next-of-kin', $candidate -> next_of_kin) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="next-of-kin-cnic">
                    Next of Kin CNIC
                </label>
                <input type="number" name="next-of-kin-cnic" class="form-control"
                       id="next-of-kin-cnic"
                       minlength="13" maxlength="13"
                       value="{{ old ('next-of-kin-cnic', $candidate -> next_of_kin_cnic) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="kin-relationship">Kin Relationship</label>
                <input type="text" name="kin-relationship" class="form-control"
                       id="kin-relationship"
                       value="{{ old ('kin-relationship', $candidate -> kin_relationship) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="contact-no">Kin Contact No</label>
                <input type="text" name="contact-no" class="form-control" id="contact-no"
                       value="{{ old ('contact-no', $candidate -> contact_no) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="shirt-size">Shirt Size</label>
                <select name="shirt-size" class="form-control select2" id="shirt-size"
                        data-placeholder="Select">
                    <option></option>
                    <option value="small" @selected(old ('shirt-size', $candidate -> shirt_size) == 'small')>
                        Small
                    </option>
                    <option value="medium" @selected(old ('shirt-size', $candidate -> shirt_size) == 'medium')>
                        Medium
                    </option>
                    <option value="large" @selected(old ('shirt-size', $candidate -> shirt_size) == 'large')>
                        Large
                    </option>
                    <option value="xl" @selected(old ('shirt-size', $candidate -> shirt_size) == 'xl')>
                        XL
                    </option>
                    <option value="xxl" @selected(old ('shirt-size', $candidate -> shirt_size) == 'xxl')>
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
                        <option value="{{ $trouser }}" @selected(old ('trouser-size', $candidate -> trouser_size) == $trouser)>
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
                        <option value="{{ $shoes }}" @selected(old ('shoes-size', $candidate -> shoes_size) == $shoes)>
                            {{ $shoes }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="weight">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control" id="weight"
                       value="{{ old ('weight', $candidate -> weight) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="height">Height (cm)</label>
                <input type="number" step="0.01" name="height" class="form-control" id="height"
                       value="{{ old ('height', $candidate -> height) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email"
                       value="{{ old ('email', $candidate -> email) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="bank-id">Bank</label>
                <select name="bank-id" class="form-control select2"
                        data-placeholder="Select"
                        id="bank-id">
                    <option></option>
                    @if(count ($banks) > 0)
                        @foreach($banks as $bank)
                            <option value="{{ $bank -> id }}"
                                    @selected(old ('bank-id', $candidate -> bank_id) == $bank -> id)>
                                {{ $bank -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="account-no">Account No</label>
                <input type="text" name="account-no" class="form-control" id="account-no"
                       value="{{ old ('account-no', $candidate -> account_no) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="company-email">Company Email</label>
                <input type="text" name="company-email" class="form-control" id="company-email"
                       value="{{ empty(trim($candidate -> company_email)) ? 'hr@jmsmanpower.com' : old ('company-email', $candidate -> company_email) }}">
            </div>
        </div>
        
        <div class="row">
            <h4 class="bg-dark text-white pt-1 pb-1 fw-semibold">Attachments</h4>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="docs-provided">
                    Documents Provided
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="docs-provided" class="form-control select2"
                        data-placeholder="Select"
                        required="required" id="docs-provided">
                    <option></option>
                    <option value="only-cv"@selected(old ('docs-provided', $candidate -> docs_provided) == 'only-cv')>
                        Only CV
                    </option>
                    <option value="passport-provided"@selected(old ('docs-provided', $candidate -> docs_provided) == 'passport-provided')>
                        Passport Provided
                    </option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="picture">Picture</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> picture)))
                        <div>
                            <a href="{{ $candidate -> document -> picture }}"
                               download="{{ $candidate -> fullName() }} - Picture">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> picture }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="picture" class="form-control" id="picture"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="passport-image">Passport</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> passport)))
                        <div>
                            <a href="{{ $candidate -> document -> passport }}"
                               download="{{ $candidate -> fullName() }} - Passport">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> passport }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="passport-image" class="form-control" id="passport-image"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="cnic-front">CNIC Front</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> cnic_front)))
                        <div>
                            <a href="{{ $candidate -> document -> cnic_front }}"
                               download="{{ $candidate -> fullName() }} - CNIC Front" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> cnic_front }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="cnic-front" class="form-control" id="cnic-front"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="cnic-back">CNIC Back</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> cnic_back)))
                        <div>
                            <a href="{{ $candidate -> document -> cnic_back }}"
                               download="{{ $candidate -> fullName() }} - CNIC Back" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> cnic_back }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="cnic-back" class="form-control" id="cnic-back"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="nicop-front">NICOP Front</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> nicop_front)))
                        <div>
                            <a href="{{ $candidate -> document -> nicop_front }}"
                               download="{{ $candidate -> fullName() }} - NICOP Front" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> nicop_front }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="nicop-front" class="form-control" id="nicop-front"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="nicop-back">NICOP Back</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> nicop_back)))
                        <div>
                            <a href="{{ $candidate -> document -> nicop_back }}"
                               download="{{ $candidate -> fullName() }} - NICOP Back" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> nicop_back }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="nicop-back" class="form-control" id="nicop-back"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="nok-1">Next of Kin #1</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> nok_1)))
                        <div>
                            <a href="{{ $candidate -> document -> nok_1 }}"
                               download="{{ $candidate -> fullName() }} - NOK-1" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> nok_1 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="nok-1" class="form-control" id="nok-1"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="nok-1">Next of Kin #2</label>
                    @if($candidate -> document && !empty(trim ($candidate -> document -> nok_2)))
                        <div>
                            <a href="{{ $candidate -> document -> nok_2 }}"
                               download="{{ $candidate -> fullName() }} - NOK-2" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> document -> nok_2 }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="nok-2" class="form-control" id="nok-2"
                       accept="image/*">
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
    </div>
</form>