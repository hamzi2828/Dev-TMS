<x-login :title="$title">
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
          <!-- /Left Text -->
          <div class="d-none d-lg-flex col-lg-7 p-0">
            <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
              <img
                src="../../assets/img/illustrations/auth-login-illustration-light.png"
                alt="auth-login-cover"
                class="img-fluid my-5 auth-illustration"
                data-app-light-img="illustrations/auth-login-illustration-light.png"
                data-app-dark-img="illustrations/auth-login-illustration-dark.png" />

              <img
                src="../../assets/img/illustrations/bg-shape-image-light.png"
                alt="auth-login-cover"
                class="platform-bg"
                data-app-light-img="illustrations/bg-shape-image-light.png"
                data-app-dark-img="illustrations/bg-shape-image-dark.png" />
            </div>
          </div>
          <!-- /Left Text -->

          <!-- Login -->
          <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
              <!-- Logo -->
              <div class="app-brand mb-4">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                      <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                      <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                    </svg>
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h3 class="mb-1">Travel Management System<br>🛫 🛬 🏨 🚘 🏝️ ⛰️ 🕋</h3>
              <p class="mb-4">Please sign-in to your account</p>


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
                    <a href="{{ route('forgot.password') }}">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password"
                    placeholder="Password" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>

                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign in</button>
              </form>

              <p class="text-center mt-5">
                <span style="font-size: 1.5rem;">New on our platform?</span>
                <br>
                <a href="{{ route ('register') }}">
                  <span style="font-size: 1.2rem;">Create an account</span>
                </a>
              </p>


            </div>
          </div>
          <!-- /Login -->
        </div>
      </div>


          <!-- Registration Success Modal -->
    @if(session('Register'))

    <div class="modal fade show" id="registrationSuccessModal" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center border-bottom-0">
                    <h5 class="modal-title text-success fw-bold" style="font-size: 1.75rem;">Registration Successful!</h5>
                </div>
                <div class="modal-body text-center px-4 pt-0">
                    <div class="mb-4">
                        <i class="bx bx-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <p class="mb-3"><strong>{{ session('Register') }}</strong></p>
                    <p class="fw-bold mb-3" style="font-size: 1.25rem;">0300-0000000</p>
                </div>
                <div class="modal-footer justify-content-center border-top-0">
                    <button type="button" class="btn btn-primary px-4" onclick="window.location.reload()">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif



</x-login>




