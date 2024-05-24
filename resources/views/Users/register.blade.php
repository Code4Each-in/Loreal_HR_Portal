@include('layout.includes.head')

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="<?php echo asset('assets/img/logo.png'); ?>" alt="Logo">
                                <span class="d-none d-lg-block">L'Oréal</span>
                            </a>
                        </div>
                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                    <p class="text-center small">Enter your details to create account</p>
                                </div>
                                <form class="row g-3 needs-validation" action="{{ route('user.create') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="col-6">
                                        <label for="fname" class="form-label">First Name<span class="text-danger">*</span></label>
                                        <input type="text" name="firstname" class="form-control" id="fname" value="{{ old('firstname') }}">
                                        @if ($errors->has('firstname'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('firstname') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-6">
                                        <label for="lname" class="form-label">Last Name<span class="text-danger">*</span></label>
                                        <input type="text" name="lastname" class="form-control" id="lname" value="{{ old('lastname') }}">
                                        @if ($errors->has('lastname'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('lastname') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-4">
                                        <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control" id="city" value="{{ old('city') }}">
                                        @if ($errors->has('city'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-4">
                                        <label for="state" class="form-label">State<span class="text-danger">*</span></label>
                                        <input type="text" name="state" class="form-control" id="state" value="{{ old('state') }}">
                                        @if ($errors->has('state'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-4">
                                        <label for="zip" class="form-label">Zip<span class="text-danger">*</span></label>
                                        <input type="number" name="zip" class="form-control" id="zip" value="{{ old('zip') }}">
                                        @if ($errors->has('zip'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('zip') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" id="address">{{ old('address') }}</textarea>
                                        @if ($errors->has('address'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="yourEmail" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password<span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" id="yourPassword">
                                        @if ($errors->has('password'))
                                        <span style="font-size: 12px;" class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label for="rePassword" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control" id="rePassword">
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                            <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                                            <div class="invalid-feedback">You must agree before submitting.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{ url('login') }}">Login</a></p>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->
@include('layout.sections.footer')


