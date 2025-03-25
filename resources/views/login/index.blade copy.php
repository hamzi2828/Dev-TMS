<x-login :title="$title">
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-cover">
            <div class="authentication-inner row m-0 ">
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
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

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
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me"
                                        value="1" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-login>