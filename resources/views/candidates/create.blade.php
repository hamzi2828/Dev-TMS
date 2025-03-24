<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('candidates.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <div class="row border-bottom mb-4">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        Note! Please choose <strong>Payment Method</strong> &amp;
                                        <strong>Transaction No.</strong> carefully,
                                        once information is saved in the system this will make impact on
                                        <strong>General Ledger</strong> and cannot be reversed.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="payment-method">
                                        Payment Method
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <select name="payment-method" class="form-control select2"
                                            data-placeholder="Select"
                                            required="required" id="payment-method">
                                        <option></option>
                                        @if(count ($payment_methods) > 0)
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method -> id }}"
                                                        @selected(old ('payment-method', '1') == $payment_method -> id)>
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
                                           value="{{ old ('transaction-no') }}" autofocus="autofocus"
                                           id="transaction-no" name="transaction-no" />
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
                                                        @selected(old ('referral-id') == $referral -> id)>
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
                                            id="principal">
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
                                
                                <div class="col-md-3 mb-3">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input is-valid" name="free-candidate"
                                               value="1" id="free-candidate">
                                        <span class="switch-toggle-slider">
                                        <span class="switch-off"></span><span class="switch-on"></span></span>
                                        <span class="switch-label">Free! (No Test Fee)</span>
                                    </label>
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
                                                        @selected(old ('job-id') == $job -> id)>
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
                                                        @selected(old ('country-id', '1') == $country -> id)>
                                                    {{ $country -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="city">Place of Birth
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <select name="city-id" id="city" class="form-control select2"
                                            data-placeholder="Select"
                                            required="required"
                                            data-allow-clear="true">
                                        <option></option>
                                        @if(count ($cities) > 0)
                                            @foreach($cities as $city)
                                                <option value="{{ $city -> id }}"
                                                        @selected(old ('city-id') == $city -> id)>
                                                    {{ $city -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="qualification-id">Qualification
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <select name="qualification-id" class="form-control select2"
                                            data-placeholder="Select"
                                            required="required"
                                            id="qualification-id">
                                        <option></option>
                                        @if(count ($qualifications) > 0)
                                            @foreach($qualifications as $qualification)
                                                <option value="{{ $qualification -> id }}"
                                                        @selected(old ('qualification-id') == $qualification -> id)>
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
                                           value="{{ old ('first-name') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="last-name">Last Name
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="last-name" class="form-control"
                                           id="last-name" oninput="validateInput(this)"
                                           value="{{ old ('last-name') }}" required="required">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="father-name">
                                        Father Name
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="father-name" class="form-control" id="father-name"
                                           required="required"
                                           value="{{ old ('father-name') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="mother-name">Mother Name
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="mother-name" class="form-control" id="mother-name"
                                           required="required"
                                           value="{{ old ('mother-name') }}">
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
                                           value="{{ old ('mobile') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="alt-no">Alternate No</label>
                                    <input type="number" name="alt-no" class="form-control" id="alt-no"
                                           value="{{ old ('alt-no') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic">
                                        CNIC
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="number" name="cnic" class="form-control" id="cnic" required="required"
                                           minlength="13" maxlength="13"
                                           value="{{ old ('cnic') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic-expiry-date">CNIC Expiry Date</label>
                                    <input type="text" name="cnic-expiry-date" class="form-control flatpickr-basic"
                                           id="cnic-expiry-date" required="required"
                                           value="{{ old ('cnic-expiry-date') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="dob">
                                        Date of Birth
                                        <sup class="text-danger fs-5 top-0">*</sup>
                                    </label>
                                    <input type="text" name="dob" class="form-control flatpickr-basic"
                                           id="dob" required="required" onchange="calculateAge(this.value)"
                                           value="{{ old ('dob') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport">Passport No</label>
                                    <input type="text" name="passport" class="form-control" id="passport"
                                           value="{{ old ('passport') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport-issue-date">Passport Issue Date</label>
                                    <input type="text" name="passport-issue-date" class="form-control flatpickr-basic"
                                           id="passport-issue-date"
                                           value="{{ old ('passport-issue-date') }}">
                                </div>
                                
                                 <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport-expiry-date">Passport Expiry Date</label>
                                    <input type="text" name="passport-expiry-date" class="form-control flatpickr-basic"
                                           id="passport-expiry-date"
                                           value="{{ old ('passport-expiry-date') }}">
                                </div>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Initialize flatpickr (assuming you're using flatpickr for the date input)
                                        const expiryDatePicker = flatpickr("#passport-expiry-date", {
                                            onChange: function (selectedDates, dateStr, instance) {
                                                checkPassportExpiry(dateStr);
                                            }
                                        });
                                    });
                                
                                    function checkPassportExpiry(selectedDate) {
                                        const expiryDate = new Date(selectedDate);
                                        const currentDate = new Date();
                                        
                                        // Calculate the date 12 months from today
                                        const nextYearDate = new Date();
                                        nextYearDate.setFullYear(currentDate.getFullYear() + 1);
                                
                                        // Check if the expiry date is within the next 12 months
                                        if (expiryDate <= nextYearDate && expiryDate >= currentDate) {
                                            alert("The passport expiry date is within the next 12 months.");
                                        }
                                    }
                                </script>
                                
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="issue-country-id">Place of Issue</label>
                                    <select name="issue-country-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="issue-country-id">
                                        <option></option>
                                        @if(count ($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{ $country -> id }}"
                                                        @selected(old ('issue-country-id', '1') == $country -> id)>
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
                                        <option value="muslim" @selected(old ('religion') == 'muslim')>Muslim</option>
                                        <option value="christan" @selected(old ('religion') == 'christan')>Christan
                                        </option>
                                        <option value="hindu" @selected(old ('religion') == 'hindu')>Hindu</option>
                                        <option value="sikh" @selected(old ('religion') == 'sikh')>Sikh</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sect">Sect</label>
                                    <select name="sect" class="form-control select2"
                                            data-placeholder="Select"
                                            id="sect">
                                        <option value="sunni" @selected(old ('sect') == 'sunni')>Sunni</option>
                                        <option value="shia" @selected(old ('sect') == 'shia')>Shia</option>
                                        <option value="whabbi" @selected(old ('sect') == 'whabbi')>Whabbi</option>
                                        <option value="salafi" @selected(old ('sect') == 'salafi')>Salafi</option>
                                        <option value="berelvi" @selected(old ('sect') == 'berelvi')>Berelvi</option>
                                        <option value="sufi" @selected(old ('sect') == 'sufi')>Sufi</option>
                                        <option value="deobandi" @selected(old ('sect') == 'deobandi')>Deobandi</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="marital-status">Marital Status</label>
                                    <select name="marital-status" class="form-control select2"
                                            data-placeholder="Select"
                                            id="marital-status">
                                        <option></option>
                                        <option value="single" @selected(old ('marital-status') == 'single')>Single
                                        </option>
                                        <option value="married" @selected(old ('marital-status') == 'married')>Married
                                        </option>
                                        <option value="divorced" @selected(old ('marital-status') == 'divorced')>
                                            Divorced
                                        </option>
                                        <option value="widow" @selected(old ('marital-status') == 'widow')>Widow
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="age">Age (Years)</label>
                                    <input type="number" name="age" class="form-control" id="age"
                                           value="{{ old ('age') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="gender">Gender
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="gender" class="form-control select2"
                                            data-placeholder="Select"
                                            required="required"
                                            id="gender">
                                        <option></option>
                                        <option value="male" @selected(old ('gender') == 'male')>Male</option>
                                        <option value="female" @selected(old ('gender') == 'female')>Female</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="blood-group">Blood Group</label>
                                    <select name="blood-group" class="form-control select2"
                                            data-placeholder="Select"
                                            id="blood-group">
                                        <option></option>
                                        <option value="A-" @selected(old ('blood-group') == 'A-')>A-</option>
                                        <option value="A+" @selected(old ('blood-group') == 'A+')>A+</option>
                                        <option value="B-" @selected(old ('blood-group') == 'B-')>B-</option>
                                        <option value="B+" @selected(old ('blood-group') == 'B+')>B+</option>
                                        <option value="AB-" @selected(old ('blood-group') == 'AB-')>AB-</option>
                                        <option value="AB+" @selected(old ('blood-group') == 'AB+')>AB+</option>
                                        <option value="O-" @selected(old ('blood-group') == 'O-')>O-</option>
                                        <option value="O+" @selected(old ('blood-group') == 'O+')>O+</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contract-period">Period of contract (Years)</label>
                                    <input type="number" name="contract-period" class="form-control"
                                           id="contract-period"
                                           value="{{ old ('contract-period') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="accommodation">Accommodation</label>
                                    <select name="accommodation" class="form-control select2"
                                            data-placeholder="Select"
                                            id="accommodation">
                                        <option></option>
                                        <option value="free" @selected(old ('accommodation') == 'free')>Free</option>
                                        <option value="not-free" @selected(old ('accommodation') == 'not-free')>
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
                                        <option value="free" @selected(old ('food') == 'free')>Free</option>
                                        <option value="not-free" @selected(old ('food') == 'not-free')>
                                            Not Free
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="salary">Salary</label>
                                    <input type="number" name="salary" class="form-control"
                                           id="salary"
                                           value="{{ old ('salary') }}">
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
                                                        @selected(old ('lead-source-id') == $source -> id)>
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
                                                        @selected(old ('province-id') == $province -> id)>
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
                                                        @selected(old ('district-id') == $district -> id)>
                                                    {{ $district -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-9 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           id="address"
                                           value="{{ old ('address') }}">
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
                                           value="{{ old ('next-of-kin') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="next-of-kin-cnic">
                                        Next of Kin CNIC
                                    </label>
                                    <input type="number" name="next-of-kin-cnic" class="form-control"
                                           id="next-of-kin-cnic"
                                           minlength="13" maxlength="13"
                                           value="{{ old ('next-of-kin-cnic') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="kin-relationship">Kin Relationship</label>
                                    <input type="text" name="kin-relationship" class="form-control"
                                           oninput="validateInput(this)"
                                           id="kin-relationship"
                                           value="{{ old ('kin-relationship') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact-no">Kin Contact No</label>
                                    <input type="number" name="contact-no" class="form-control" id="contact-no"
                                           value="{{ old ('contact-no') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="shirt-size">Shirt Size</label>
                                    <select name="shirt-size" class="form-control select2" id="shirt-size"
                                            data-placeholder="Select">
                                        <option></option>
                                        <option value="small" @selected(old ('shirt-size') == 'small')>Small</option>
                                        <option value="medium" @selected(old ('shirt-size') == 'medium')>Medium</option>
                                        <option value="large" @selected(old ('shirt-size') == 'large')>Large</option>
                                        <option value="xl" @selected(old ('shirt-size') == 'xl')>XL</option>
                                        <option value="xxl" @selected(old ('shirt-size') == 'xxl')>XXL</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="trouser-size">Trouser Size</label>
                                    <select name="trouser-size" class="form-control select2" id="trouser-size"
                                            data-placeholder="Select">
                                        <option></option>
                                        @for($trouser = 28; $trouser <= 44; $trouser+=2)
                                            <option value="{{ $trouser }}" @selected(old ('trouser-size') == $trouser)>
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
                                            <option value="{{ $shoes }}" @selected(old ('shoes-size') == $shoes)>
                                                {{ $shoes }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="weight">Weight (kg)</label>
                                    <input type="number" step="0.01" name="weight" class="form-control" id="weight"
                                           value="{{ old ('weight') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="height">Height (ft,in)</label>
                                    <input type="number" step="0.01" name="height" class="form-control" id="height"
                                           value="{{ old ('height') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           value="{{ old ('email') }}">
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
                                                        @selected(old ('bank-id') == $bank -> id)>
                                                    {{ $bank -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="account-no">Account No</label>
                                    <input type="text" name="account-no" class="form-control" id="account-no"
                                           value="{{ old ('account-no') }}">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="company-email">Company Email</label>
                                    <input type="email" name="company-email" class="form-control" id="company-email"
                                           value="{{ old ('company-email', 'hr@jmsmanpower.com') }}">
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
                                        <option value="only-cv"@selected(old ('docs-provided') == 'only-cv')>
                                            Only CV
                                        </option>
                                        <option value="passport-provided"@selected(old ('docs-provided') == 'passport-provided')>
                                            Passport Provided
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="picture">Picture</label>
                                    <input type="file" name="picture" class="form-control" id="picture"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="passport-image">Passport</label>
                                    <input type="file" name="passport-image" class="form-control" id="passport-image"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic-front">CNIC Front</label>
                                    <input type="file" name="cnic-front" class="form-control" id="cnic-front"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic-back">CNIC Back</label>
                                    <input type="file" name="cnic-back" class="form-control" id="cnic-back"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cnic-front">NICOP Front</label>
                                    <input type="file" name="nicop-front" class="form-control" id="nicop-front"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="nicop-back">NICOP Back</label>
                                    <input type="file" name="nicop-back" class="form-control" id="nicop-back"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="nok-1">Next of Kin #1</label>
                                    <input type="file" name="nok-1" class="form-control" id="nok-1"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="nok-2">Next of Kin #1</label>
                                    <input type="file" name="nok-2" class="form-control" id="nok-2"
                                           accept="image/*">
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