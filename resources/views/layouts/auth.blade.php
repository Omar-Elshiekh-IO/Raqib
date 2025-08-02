<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <title>{{ config('app.name', 'Laravel') }} - @yield('page-title', 'Auth')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');
        * { box-sizing: border-box; }
        body {
            background: url('{{ asset('assets/images/bg-login.webp') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: -20px 0 50px;
            /* fallback color if image fails */
            background-color: #222;
        }
        h1 { font-weight: bold; margin: 0; }
        h2 { text-align: center; }
        p { font-size: 14px; font-weight: 100; line-height: 20px; letter-spacing: 0.5px; margin: 20px 0 30px; }
        span { font-size: 12px; }
        a { color: #333; font-size: 14px; text-decoration: none; margin: 15px 0; }
        button, .ghost {
            border-radius: 20px;
            border: 1px solid var(--accent-main, #08253F);
            background-color: var(--accent-main, #08253F);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in, background 0.3s, border 0.3s;
        }
        button:active { transform: scale(0.95); }
        button:focus { outline: none; }
        button.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }
        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }
        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
        }
        .container {
            background-color: var(--accent-color, #fff);
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }
        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }
        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }
        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }
        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        .container.right-panel-active .overlay-container{
            transform: translateX(-100%);
        }
        .overlay {
            background: var(--accent-gradient, linear-gradient(to right, #FF4B2B, #FF416C));
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out, background 0.3s;
        }
        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }
        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }
        @media (max-width: 900px) {
            body {
                height: auto;
                min-height: 100vh;
                padding: 20px 0;
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                border-radius: 10px;
                min-height: auto !important;
                display: flex;
                flex-direction: column;
                position: relative;
                overflow: visible;
            }
            .form-container {
                position: static !important;
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                box-shadow: none !important;
                transform: none !important;
                animation: none !important;
                opacity: 1 !important;
                z-index: 2 !important;
            }
            .sign-in-container, .sign-up-container {
                width: 100% !important;
                min-width: 0 !important;
                opacity: 1 !important;
                z-index: 2 !important;
                transform: none !important;
                animation: none !important;
                position: static !important;
                display: block !important;
                margin-bottom: 20px;
            }
            .container.right-panel-active .sign-in-container,
            .container.right-panel-active .sign-up-container {
                transform: none !important;
                opacity: 1 !important;
                display: block !important;
            }
            .overlay-container {
                display: none !important;
            }
            /* Add mobile toggle buttons */
            .mobile-toggle {
                display: flex !important;
                justify-content: center;
                gap: 10px;
                margin: 20px 0;
                padding: 0 20px;
            }
            .mobile-toggle button {
                flex: 1;
                max-width: 150px;
                padding: 10px 20px;
                border-radius: 25px;
                border: 2px solid var(--accent-main, #2B8B68);
                background: transparent;
                color: var(--accent-main, #2B8B68);
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .mobile-toggle button.active,
            .mobile-toggle button:hover {
                background: var(--accent-main, #2B8B68);
                color: white;
            }
            /* Hide inactive form on mobile */
            .mobile-hide {
                display: none !important;
            }
        }
        @media (max-width: 600px) {
            .container {
                min-width: 0 !important;
                width: 100vw !important;
                min-height: 100vh !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }
            form {
                padding: 24px 10px 24px 10px !important;
            }
            h1 {
                font-size: 1.5rem !important;
            }
            .overlay-panel {
                padding: 0 10px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <!-- Mobile Toggle Buttons (hidden on desktop) -->
        <div class="mobile-toggle" style="display: none;">
            <button type="button" id="mobileSignIn" class="active">Sign In</button>
            <button type="button" id="mobileSignUp">Sign Up</button>
        </div>
        
        <div class="form-container sign-up-container" id="signUpForm">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Create Account</h1>
             
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                <div style="margin: 10px 0 20px 0; text-align: left; width: 100%;">
                    <label style="font-size: 13px; display: flex; align-items: center; gap: 8px; font-weight: 500; color: #222;">
                        <input type="checkbox" name="terms" required style="margin-inline-end: 10px; accent-color: var(--accent-main, #2B8B68); inline-size: 16px; block-size: 16px;" />
                        <span style="font-size: 13px; color: #222; font-weight: 500;">
                            I agree to the
                            <a href="/terms" target="_blank" style="color: var(--accent-main, #2B8B68); text-decoration: underline; font-weight: 500; font-size: 13px;">Terms and Conditions</a>
                            and the
                            <a href="/privacy" target="_blank" style="color: var(--accent-main, #2B8B68); text-decoration: underline; font-weight: 500; font-size: 13px;">Privacy Policy</a>
                        </span>
                    </label>
                </div>
                @if ($errors->has('name'))
                    <span>{{ $errors->first('name') }}</span>
                @endif
                @if ($errors->has('email'))
                    <span>{{ $errors->first('email') }}</span>
                @endif
                @if ($errors->has('password'))
                    <span>{{ $errors->first('password') }}</span>
                @endif
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container" id="signInForm">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign in</h1>
        
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                <input type="password" name="password" placeholder="Password" required />
                @if ($errors->has('email'))
                    <span>{{ $errors->first('email') }}</span>
                @endif
                @if ($errors->has('password'))
                    <span>{{ $errors->first('password') }}</span>
                @endif
                <a href="#" id="forgotPasswordLink">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn" type="button">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Welcome in Raqib</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp" type="button">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; color:#222; border-radius:10px; padding:2rem 2rem 1.5rem 2rem; min-width:320px; max-width:90vw; box-shadow:0 8px 32px 0 rgba(31,38,135,0.37); display:flex; flex-direction:column; align-items:center;">
            <h2 style="margin-bottom:1rem; color:#222;">Reset Password</h2>
            <form method="POST" action="{{ route('password.email') }}" style="width:100%; display:flex; flex-direction:column; align-items:center;">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required style="margin-bottom:1rem; width:100%; padding:10px; border-radius:5px; border:1px solid #ccc;" />
                <button type="submit" style="margin-bottom:1rem; background:#FF4B2B; color:#fff; border:none; border-radius:20px; padding:10px 30px; font-weight:bold;">Send Reset Link</button>
                <button type="button" id="closeForgotModal" style="background:#eee; color:#222; border:none; border-radius:20px; padding:8px 24px;">Cancel</button>
            </form>
        </div>
    </div>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        
        // Desktop toggle functionality
        if (signUpButton) {
            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
            });
        }
        
        if (signInButton) {
            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
            });
        }

        // Mobile toggle functionality
        const mobileSignInBtn = document.getElementById('mobileSignIn');
        const mobileSignUpBtn = document.getElementById('mobileSignUp');
        const signInForm = document.getElementById('signInForm');
        const signUpForm = document.getElementById('signUpForm');

        function showSignIn() {
            if (signInForm && signUpForm) {
                signInForm.classList.remove('mobile-hide');
                signUpForm.classList.add('mobile-hide');
                mobileSignInBtn.classList.add('active');
                mobileSignUpBtn.classList.remove('active');
            }
        }

        function showSignUp() {
            if (signInForm && signUpForm) {
                signInForm.classList.add('mobile-hide');
                signUpForm.classList.remove('mobile-hide');
                mobileSignInBtn.classList.remove('active');
                mobileSignUpBtn.classList.add('active');
            }
        }

        if (mobileSignInBtn && mobileSignUpBtn) {
            mobileSignInBtn.addEventListener('click', showSignIn);
            mobileSignUpBtn.addEventListener('click', showSignUp);
        }

        // Initialize mobile view
        function initializeMobileView() {
            if (window.innerWidth <= 900) {
                // Show mobile toggle buttons
                const mobileToggle = document.querySelector('.mobile-toggle');
                if (mobileToggle) {
                    mobileToggle.style.display = 'flex';
                }
                // Initially show sign in form on mobile
                showSignIn();
            } else {
                // Hide mobile toggle buttons on desktop
                const mobileToggle = document.querySelector('.mobile-toggle');
                if (mobileToggle) {
                    mobileToggle.style.display = 'none';
                }
                // Remove mobile hide classes on desktop
                if (signInForm && signUpForm) {
                    signInForm.classList.remove('mobile-hide');
                    signUpForm.classList.remove('mobile-hide');
                }
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', initializeMobileView);
        
        // Re-initialize on resize
        window.addEventListener('resize', initializeMobileView);

        // Forgot Password Modal logic
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const forgotPasswordModal = document.getElementById('forgotPasswordModal');
        const closeForgotModal = document.getElementById('closeForgotModal');

        if (forgotPasswordLink && forgotPasswordModal && closeForgotModal) {
            forgotPasswordLink.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.overlay-container').style.display = 'none';
                document.querySelector('.form-container.sign-up-container').style.display = 'none';
                document.querySelector('.form-container.sign-in-container').style.display = 'none';
                forgotPasswordModal.style.display = 'flex';
            });
            closeForgotModal.addEventListener('click', function() {
                forgotPasswordModal.style.display = 'none';
                document.querySelector('.overlay-container').style.display = '';
                document.querySelector('.form-container.sign-up-container').style.display = '';
                document.querySelector('.form-container.sign-in-container').style.display = '';
            });
        }

        // Accent color sync for sign in/sign up module
        function setAccentColor(accent) {
            document.documentElement.style.setProperty('--accent-main', accent.main || '#2B8B68');
            document.documentElement.style.setProperty('--accent-gradient', accent.gradient || 'linear-gradient(to right, #2B8B68, #08253F)');
            document.documentElement.style.setProperty('--accent-color', accent.bg || '#fff');
        }
        // Example: Listen for a custom event or call setAccentColor from your color switcher logic
        // Example usage: setAccentColor({main: '#007bff', gradient: 'linear-gradient(to right, #007bff, #00c6ff)', bg: '#f7f7f7'});
    </script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>
