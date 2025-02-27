<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="login-card">
        <h3 class="text-center mb-4">Login</h3>
        <form id="loginForm" action="{{route('user.authenticate')}}" method="POST" class="needs-validation" novalidate>
             @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif
            <!-- Email or Username -->
            <div class="mb-3">
                <label for="adminEmail" class="form-label">Email or Username</label>
                <input type="text" name="email" class="form-control" @error('email') is-invalid @enderror id="adminEmail" placeholder="Enter your email or username"
                   value="{{ old('email')}}" required>
                    @error('email')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" @error('password') is-invalid @enderror id="adminPassword" placeholder="Enter your password"
                    required>
                @error('password')
                        <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <a href="#" class="text-decoration-none ms-1">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

    </div>
    <script src="{{asset('assets/js/admin/pages/login/login-form-validate.js')}}"></script>
</body>

</html>