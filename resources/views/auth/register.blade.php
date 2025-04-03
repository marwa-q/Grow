<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />

    <title>Register</title>
</head>

<body>
    <div class="register-container">
        <div class="register-image">
            <div class="illustration">
                <!-- This would be replaced with the actual illustration -->
            </div>
            <h1>CHARITY Connect</h1>
            <p>Making a difference, together.</p>
        </div>
        <div class="register-form">
            <div class="register-form-header">
                <h2><span class="heart-icon">❤️</span> CHARITY Connect</h2>
                <p>Join our community and start making an impact</p>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- First Name -->
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" value="{{ old('first_name') }}"
                        placeholder="Enter first name" required />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" value="{{ old('last_name') }}"
                        placeholder="Enter last name" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Create Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a strong password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm your password" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>



                <button type="submit" class="register-button">Create Account</button>
            </form>
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</body>

</html>
