<!DOCTYPE html>
<html lang="en"> <!-- default theme light -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Cooperative Society</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* background: linear-gradient(to right, #e0f7fa, #ffffff); */
            background-image: url("{{asset('/assets/images/background1.jpg')}}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-blend-mode: difference   ;
        }

        .login-container{
            min-height: 100vh;
            --bs-bg-opacity: .6
        }
        
        .login-card {
            max-width: 420px;
            width: 100%;
            border-radius: 16px;
            background-color: #fff;
            opacity: .8;
        }
    </style>
</head>

<body class="">
    <div class="container-fluid d-flex justify-content-center align-items-center position-relative login-container bg-white">
    <div class="login-card card shadow p-4">
        <div class="text-center mb-4">
            <img src="{{asset('/assets/images/logo.png')}}" class="company-logo mb-2 card-img-top" alt="Logo" style="width: 100px">
            <p class="text-muted small">Welcome back! Please login to your account.</p>
        </div>

        <form id="loginForm" action="{{ route('user.authenticate') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <!-- Username -->
            <div class="mb-3">
                <label for="adminEmail" class="form-label">Username</label>
                <input type="text" name="name" id="adminEmail"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Enter your username" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input type="password" name="password" id="adminPassword"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <a href="#" class="text-decoration-none small">Forgot Password?</a>
            </div> --}}

            <!-- Login Button -->
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/js/admin/pages/login/login-form-validate.js')}}"></script>
</body>

</html>

