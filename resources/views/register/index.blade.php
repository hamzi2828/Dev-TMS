<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
      data-assets-path="{{ url ('/assets') }}/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token () }}">
    <meta name="app-path" content="{{ config ('app.url') }}">
    <title>{{ $title }} | {{ config ('app.name') }}</title>>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/iconify-icons.css') }}"/>

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/pickr/pickr-themes.css') }}" />

    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->


    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="/" class="app-brand auth-cover-brand">
        <span class="app-brand-logo demo">
          <span class="text-primary">
            <img src="{{ asset('assets/main_logo.png') }}" alt="logo" />
          </span>
        </span>
        <h3 class="brand-text text-primary ms-1">Travel Management System</h3>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-xl-flex col-xl-8 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center">
            <img
              src="{{ asset('/assets/img/illustrations/auth-register-illustration-light.png') }}"
              alt="auth-register-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/auth-register-illustration-light.png"
              data-app-dark-img="illustrations/auth-register-illustration-dark.png" />
            <img
              src="{{ asset('/assets/img/illustrations/bg-shape-image-light.png') }}"
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
              <div class="mb-6 mt-8">
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

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->

    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('/assets/vendor/libs/i18n/i18n.js') }}"></script>

    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Main JS -->

    <script src="{{ asset('/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/assets/js/pages-auth.js') }}"></script>
  </body>
</html>
