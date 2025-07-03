<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Reset</b> Password</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Anda bisa mereset password Anda di sini.</p>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="input-group mb-3">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
</body>
</html>
