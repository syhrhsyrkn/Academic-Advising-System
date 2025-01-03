<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>i-Plan - Register</title>

    <link rel="shortcut icon" href="assets/img/logo-small.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/feather/feather.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="assets/img/login.jpg" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Sign Up</h1>
                            <p class="account-subtitle">Enter details to create your account</p>

                            <!-- Laravel Registration Form -->
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name Input -->
                                <div class="form-group">
                                    <label for="name">Name <span class="login-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>

                                <!-- Email Input -->
                                <div class="form-group">
                                    <label for="email">Email <span class="login-danger">*</span></label>
                                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username">
                                    <span class="profile-views"><i class="fas fa-envelope"></i></span>
                                </div>

                                <!-- Password Input -->
                                <div class="form-group">
                                    <label for="password">Password <span class="login-danger">*</span></label>
                                    <input id="password" class="form-control pass-input" type="password" name="password" required autocomplete="new-password">
                                    <span class="profile-views feather-eye toggle-password"></span>
                                </div>

                                <!-- Password Confirmation Input -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password <span class="login-danger">*</span></label>
                                    <input id="password_confirmation" class="form-control pass-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                                    <span class="profile-views feather-eye reg-toggle-password"></span>
                                </div>

                                <!-- Terms and Conditions -->
                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="form-group">
                                        <label for="terms">
                                            <input type="checkbox" name="terms" id="terms" required>
                                            <span>I agree to the 
                                                <a target="_blank" href="{{ route('terms.show') }}">Terms of Service</a> and 
                                                <a target="_blank" href="{{ route('policy.show') }}">Privacy Policy</a>.
                                            </span>
                                        </label>
                                    </div>
                                @endif

                                <!-- Already Registered -->
                                <div class="dont-have">Already Registered? <a href="{{ route('login') }}">Login</a></div>

                                <!-- Submit Button -->
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
