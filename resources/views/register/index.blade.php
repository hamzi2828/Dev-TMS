<x-login :title="$title">

    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
          <!-- /Left Text -->
          <div class="d-none d-lg-flex col-lg-7 p-0">
            <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
              <img
                src="../../assets/img/illustrations/auth-register-illustration-light.png"
                alt="auth-register-cover"
                class="img-fluid my-5 auth-illustration"
                data-app-light-img="illustrations/auth-register-illustration-light.png"
                data-app-dark-img="illustrations/auth-register-illustration-dark.png" />

              <img
                src="../../assets/img/illustrations/bg-shape-image-light.png"
                alt="auth-register-cover"
                class="platform-bg"
                data-app-light-img="illustrations/bg-shape-image-light.png"
                data-app-dark-img="illustrations/bg-shape-image-dark.png" />
            </div>
          </div>
          <!-- /Left Text -->

         <!-- Register -->
         <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
            <div class="w-px-400 mx-auto mt-12 pt-5">
            <h4 class="mb-1">Become A Partner 🚀</h4>
            <p class="mb-6">Make & manage your booking easy!</p>

            @include('_partials.errors.validation-errors')
            <form id="formAuthentication" class="mb-3" action="{{ route ('register') }}" method="post">
                @csrf
        <div class="row">
        <div class="col-12 col-md-6 mb-3">
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Full Name*" value="{{ old('full_name') }}" required />
        </div>
        <div class="col-12 col-md-6 mb-3">
        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company/Business Name*" value="{{ old('company_name') }}" required />
        </div>
        <div class="col-12 col-md-6 mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email*" value="{{ old('email') }}" required />
        </div>
        <div class="col-12 col-md-6 mb-3">
        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number*" value="{{ old('mobile_number') }}" required />
        </div>
        <div class="col-12 mb-3">
        <input type="text" class="form-control" id="address" name="address" placeholder="Address*" value="{{ old('address') }}" required />
        </div>
        <div class="col-12 col-md-6 mb-3">
        <input type="text" class="form-control" id="city" name="city" placeholder="City*" value="{{ old('city') }}" required />
        </div>
        <div class="col-12 col-md-6 mb-3">
        <input type="text" class="form-control" id="country" name="country" placeholder="Country*" value="{{ old('country') }}" required />
        </div>
        </div>
        <div class="mb-6 form-password-toggle form-control-validation">
        <label class="form-label" for="password">Password</label>
        <div class="input-group input-group-merge">
        <input
        type="password"
        id="password"
        class="form-control"
        name="password"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="password" required />
        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
        </div>
        <div class="mb-6 form-password-toggle form-control-validation">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="input-group input-group-merge">
        <input
        type="password"
        id="password_confirmation"
        class="form-control"
        name="password_confirmation"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="password_confirmation" required />
        <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
        </div>
                <div class="mb-6 mt-8" style="margin-top: 1.2rem; margin-bottom: 1.2rem;">
                <div class="form-check mb-8 ms-2">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                </div>
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
            </form>

            <p class="text-center mt-5">
                <span style="font-size: 1.5rem;">Already have an account?</span>
                <br>
                <a href="{{ route ('login') }}">
                <span style="font-size: 1.2rem;">Sign in instead</span>
                </a>
            </p>


            </div>
        </div>
  <!-- /Register -->
        </div>
      </div>




</x-login>
