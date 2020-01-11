<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/demo/favicon.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register</title>
    <!-- CSS -->
    <link href="./assets/vendors/material-icons/material-icons.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/linea-icons/styles.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/mono-social-icons/monosocialiconsfont.css" rel="stylesheet" type="text/css" />
    <link href="./assets/vendors/feather-icons/feather.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.1.3/mediaelementplayer.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,900,900i" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body class="body-bg-full profile-page" style="background-image: url(./assets/demo/error-page.jpg)">
    <div id="wrapper" class="row wrapper">
        <div class="col-10 ml-sm-auto col-sm-8 col-md-4 ml-md-auto login-center mx-auto">
            <div class="navbar-header text-center mb-5">
                <a href="./index.html">
                    <img alt="" src="./assets/demo/logo-expand-dark.png" />
                </a>
            </div>
            <!-- /.navbar-header -->
            <h5><a href="javascript:void(0);">Sign Up</a></h5>
            <p>Signing up is easy. It only takes a few steps and you'll be up and running in no time.</p>
            <form id="loginform" method="POST" action="{{ route('register') }}" />
            {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Name" value="{{ old('name') }}" name="name" required />
                    @if ($errors->has('name'))
                        <span class="help-block invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}" name="email" required  />
                    @if ($errors->has('email'))
                        <span class="help-block invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" value="{{ old('username') }}" name="username" required />
                    @if ($errors->has('username'))
                        <span class="help-block invalid-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required />
                    @if ($errors->has('password'))
                        <span class="help-block invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Confirm Password" name="password_confirmation" required />
                </div>
                <div class="form-group">
                    <label>Passcode</label>
                    <input type="password" class="form-control{{ $errors->has('passcode') ? ' is-invalid' : '' }}" placeholder="Passcode" name="passcode" required />
                    @if ($errors->has('passcode'))
                        <span class="help-block invalid-feedback">
                            <strong>{{ $errors->first('passcode') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- /.form-group -->
                <div class="form-group text-center no-gutters mb-4">
                    <button class="btn btn-block btn-lg btn-color-scheme text-uppercase fs-12 fw-600" type="submit">Sign Up</button>
                </div>
            </form>
            <!-- /.form-horzontal -->
            <footer class="col-sm-12 text-center">
                <hr />
                <p>Already have an account? <a href="{{ url('login') }}" class="text-primary m-l-5"><b>Log In</b></a>
                </p>
            </footer>
        </div>
        <!-- /.login-center -->
    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="./assets/js/material-design.js"></script>
</body>

</html>