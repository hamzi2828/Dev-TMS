<x-login :title="$title">
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="/" class="app-brand auth-cover-brand">
        <span class="app-brand-logo demo">
          <span class="text-primary">
            <img src="{{ asset('assets/main_logo.png') }}" alt="logo" />
          </span>
        </span>
        <h2 class="brand-text text-primary ms-1">Travel Management System</h2>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-xl-flex col-xl-8 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center">
            <img
              src="{{ asset('assets/img/illustrations/auth-login-illustration-light.png') }}"
              alt="auth-login-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
            <img
              src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6 bg-white">
            <div class="w-px-400 mx-auto mt-12 pt-5">
                <h4 class="mb-1">Welcome to {{ config('app.name') }}! 👋</h4>
                <p class="mb-6">Please sign-in to your account  </p>

                @include('_partials.errors.validation-errors')
                <form id="formAuthentication" class="mb-3" action="{{ route ('authenticate') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email address" value="{{ old ('email') }}"
                            autofocus="autofocus" />
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                                placeholder="Password" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>
                <div class="my-8">
                    <div class="d-flex justify-content-between">
                      <div class="form-check mb-0 ms-2">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                      </div>
                      <a href="auth-forgot-password-cover.html">
                        <p class="mb-0">Forgot Password?</p>
                      </a>
                    </div>
                  </div>
                <div class="mt-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
            </form>

            <p class="text-center mt-5">
                <span style="font-size: 1.5rem;">New on our platform?</span>
                <br>
                <a href="{{ route ('register') }}">
                  <span style="font-size: 1.2rem;">Create an account</span>
                </a>
              </p>
        </div>
        <!-- /Login -->
      </div>
    </div>
    <!-- / Content -->

    <!-- Registration Success Modal -->
    @if(session('Register'))
    <div class="modal fade show" id="registrationSuccessModal" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content d-flex align-items-center justify-content-center">
                <div class="modal-header">
                    <h5 class="modal-title text-success" style="font-size: 1.5rem;">Registration Successful!</h5>
                </div>
                <div class="modal-body">
                    <p>{{ session('Register') }}</p>
                    <p>0300-0000000</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalElement = document.getElementById('registrationSuccessModal');
            if (modalElement) {
                var registrationModal = new bootstrap.Modal(modalElement);
                registrationModal.show();

                // Close modal when clicking outside
                modalElement.addEventListener('click', function(e) {
                    if (e.target === this) {
                        registrationModal.hide();
                    }
                });

                // Close modal when clicking OK button
                var okButton = modalElement.querySelector('.btn-primary');
                if (okButton) {
                    okButton.addEventListener('click', function() {
                        registrationModal.hide();
                    });
                }
            }
        });
    </script>
    @endpush
</x-login>
