<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir Pintar — Masuk</title>

    <script>
        (function () {
            try {
                if (localStorage.getItem('kp-theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) { /* storage unavailable */ }
        })();
    </script>

    <meta name="theme-color" content="#4f46e5" id="metaThemeColor">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/vendor/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/vendor/admin/dist/css/adminlte.min.css">
    <!-- Kasir Pintar theme (must load after AdminLTE) -->
    <link rel="stylesheet" href="/assets/css/theme.css">
</head>

<body class="hold-transition login-page kp-login">
    <div class="login-box">

        <div class="kp-login-brand">
            <span class="kp-logo"><i class="fas fa-cash-register"></i></span>
            <h1 class="kp-brand-name">Kasir Pintar</h1>
            <p class="kp-brand-tag">Sistem Kasir &amp; Point of Sale</p>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-body">
                <p class="login-box-msg">Masuk untuk memulai sesi</p>

                @if (session()->has('loginError'))
                    <div class="alert alert-danger">{{ session('loginError') }}</div>
                @endif

                <form action="/login" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/vendor/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/vendor/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/vendor/admin/dist/js/adminlte.min.js"></script>
</body>

</html>
