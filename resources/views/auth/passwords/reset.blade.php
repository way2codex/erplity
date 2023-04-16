<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashrock/color-admin/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Mar 2019 15:17:51 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ERP-Software</title>
    @include('layouts.common.header_style')

</head>

<body class="authentication-bg">
    <!-- Start wrapper-->
    <div id="wrapper">
        <div class="card card-authentication1 mx-auto my-5 animated zoomIn">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="{{ asset('public/assets/images/logo-icon.png') }}" />
                    </div>
                    <div class="card-title text-uppercase text-center py-2">Reset Password</div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="form-group">
                            <div class="position-relative has-icon-left">
                                <label for="exampleInputPassword" class="sr-only">Old Password</label>
                                <input type="password" id="exampleInputPassword" placeholder="Old Password" name="old_password" class="form-control @error('password') is-invalid @enderror" name="old_password" required autocomplete="current-password">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="position-relative has-icon-left">
                                <label for="exampleInputPassword" class="sr-only">New Password</label>
                                <input type="password" id="exampleInputPassword" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="position-relative has-icon-left">
                                <label for="exampleInputPassword" class="sr-only">Confirm Password</label>
                                <input type="password" id="exampleInputPassword" placeholder="Confirm Password" name="password_confirmation" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" required autocomplete="current-password">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mr-0 ml-0">
                            <div class="form-group col-6">
                                {{-- <div class="icheck-material-primary">
                                    <input type="checkbox" id="user-checkbox" checked="" />
                                    <label for="user-checkbox">Remember me</label>
                                </div> --}}
                            </div>
                            <div class="form-group col-6 text-right">
                                <a href="{{ route('login') }}">Login</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-danger shadow-danger btn-block waves-effect waves-light">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.common.footer_script')
</body>

<!-- Mirrored from codervent.com/dashrock/color-admin/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Mar 2019 15:17:51 GMT -->

</html>
