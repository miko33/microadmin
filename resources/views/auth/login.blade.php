<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/demo/favicon.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    <!-- CSS -->
    <link href="./assets/vendors/feather-icons/feather.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,900,900i" rel="stylesheet" type="text/css" />
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body class="body-bg-full profile-page" style="background-image: url(./assets/demo/error-page.jpg)">
        <div id="wrapper" class="row wrapper">
            <div class="container-min-full-height d-flex justify-content-center align-items-center">
                <div class="login-center">
                    <div class="navbar-header text-center mb-5">
                        <a href="./index.html">
                            <img alt="" src="./assets/demo/logo-expand-dark.png" />
                        </a>
                    </div>
                    <!-- /.navbar-header -->
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="example-login">Email or Username</label>
                            <input id="example-login" type="text" placeholder="username" class="form-control form-control-line{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login" value="{{ old('login') }}" required autofocus />
                        </div>
                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="example-password">Password</label>
                            <input id="example-password" type="password" placeholder="password" class="form-control form-control-line{{ $errors->has('login') ? ' is-invalid' : '' }}" name="password" required />

                            @if ($errors->has('login'))
                            <span class="text-center help-block invalid-feedback">
                                <strong>{{ $errors->first('login') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-lg btn-color-scheme text-uppercase fs-12 fw-600" type="submit">Login</button>
                        </div>
                        <div class="form-group no-gutters mb-0">
                            <div class="col-md-12 d-flex">
                                <div class="checkbox checkbox-primary mr-auto">
                                    <label class="d-flex">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} /> <span class="label-text">Remember me</span>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.form-group -->
                    </form>
                    <!-- /.form-material -->
                </div>
                <!-- /.login-center -->
            </div>
            <!-- /.d-flex -->
        </div>
        <!-- /.body-container -->


        <!-- Sign In Modal -->
        <div id="passcode-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <div class="modal-body">
                        <div class="text-center my-3">
                            <a href="./index.html" class="text-success">
                                <img src="./assets/demo/logo-expand-dark.png" alt="" />
                            </a>
                        </div>
                        <form id="passcode-form" class="form-horizontal" method="POST" action="{{ route('passcode') }}">
                            {{ csrf_field() }}
                            <p class="text-center text-muted">Enter your passcode to access the admin.</p>
                            <div class="form-group no-gutters">
                                <label for="example-passcode">Passcode</label>
                                <input type="password" class="form-control form-control-line{{ Session::get('error') ? ' is-invalid' : '' }}" name="passcode" id="example-passcode" required autofocus />

                                <span class="text-center help-block invalid-feedback error-passcode" style="display: none;">
                                    <strong>Invalid Passscode</strong>
                                </span>

                            </div>
                            <div class="form-group no-gutters mb-5">
                                <button class="btn btn-block btn-lg btn-color-scheme text-uppercase fs-12 fw-600" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Scripts -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.2/umd/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>

        <script type="text/javascript">

            $(window).on('load', function (e) {

                if (location.search == '?passcode') {
                    $('#passcode-modal').modal('show');
                }

                $('#passcode-modal').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });

            });

            $( "#passcode-form" ).submit(function(e) {

                e.preventDefault();

                $.ajax({
                    url : $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status) {
                            window.location.replace('/login');
                        } else {
                            var el = $('.error-passcode');
                            el.css('display', 'block');
                            el.parent().addClass('has-error');
                            el.siblings('input').addClass('is-invalid');
                        }
                    }
                });

            });

        </script>

    </body>

    </html>