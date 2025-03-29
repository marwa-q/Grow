<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

    <title>Log in</title>
</head>

<body>
    <div class="login-container">
        <div class="login-image">
            <div class="illustration">
                <!-- You can add your actual illustration here -->
            </div>
            <div class="illustration-text">
                <h1>CHARITY Connect</h1>
                <p>Making a difference, together.</p>
            </div>
        </div>

        <div class="login-form">
            <div class="login-form-header">
                <h2><span class="heart-icon">❤️</span> CHARITY Connect</h2>
                <h3>Welcome Back!</h3>
                <p>Sign in to continue your charitable journey</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required
                        autofocus class="block mt-1 w-full" value="{{ old('email') }}" />
                    @error('email')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                        class="block mt-1 w-full" />
                    @error('password')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div style="padding-bottom: 1rem">
                    <label for="remember_me" class="inline-flex items-center">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />

                    </label>
                </div>

                <!-- Error Message -->
                <h4 id="forloginerror" style="color: red">{{ session('status') }}</h4>

                <button type="submit" class="sign-in-button">Sign In</button>
            </form>

            <div class="signup-link">
                Don't have an account? <a href="{{ route('register') }}">Sign up now</a>
            </div>
        </div>
    </div>

</body>

</html>
