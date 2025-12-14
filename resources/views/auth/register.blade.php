<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - SIX MONKEY'S</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(-5deg); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .float-animation { animation: float 6s ease-in-out infinite; }
        .float-animation-2 { animation: float2 8s ease-in-out infinite; animation-delay: 1s; }
        .pulse-animation { animation: pulse 3s ease-in-out infinite; }
        .rotate-animation { animation: rotate 20s linear infinite; }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: system-ui, -apple-system, sans-serif; overflow-x: hidden;">
    <div style="display: flex; min-height: 100vh;">
        <!-- Left Side - Light Gray with Animation (60%) -->
        <div style="flex: 0 0 60%; background: linear-gradient(to bottom, #f3f4f6, #e5e7eb); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center;">
            <!-- Animated Background Elements -->
            <div style="position: absolute; width: 100%; height: 100%;">
                <!-- Floating Circles -->
                <div class="float-animation" style="position: absolute; top: 10%; left: 10%; width: 100px; height: 100px; background: rgba(30, 58, 95, 0.1); border-radius: 50%;"></div>
                <div class="float-animation-2" style="position: absolute; top: 60%; left: 20%; width: 150px; height: 150px; background: rgba(30, 58, 95, 0.08); border-radius: 50%;"></div>
                <div class="float-animation" style="position: absolute; bottom: 20%; right: 15%; width: 120px; height: 120px; background: rgba(30, 58, 95, 0.12); border-radius: 50%;"></div>
                
                <!-- Floating Squares -->
                <div class="float-animation-2" style="position: absolute; top: 30%; right: 25%; width: 80px; height: 80px; background: rgba(30, 58, 95, 0.1); transform: rotate(45deg);"></div>
                <div class="float-animation" style="position: absolute; bottom: 30%; left: 25%; width: 60px; height: 60px; background: rgba(30, 58, 95, 0.08); transform: rotate(45deg);"></div>
                
                <!-- Rotating Ring -->
                <div class="rotate-animation" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 200px; height: 200px; border: 3px dashed rgba(30, 58, 95, 0.15); border-radius: 50%;"></div>
            </div>
            
            <!-- Central Logo/Animation -->
            <div style="position: relative; z-index: 10; text-align: center;">
                <div class="pulse-animation">
                    <h1 style="font-size: 4rem; font-weight: bold; color: #1e3a5f; text-transform: uppercase; margin-bottom: 1rem;">SIX</h1>
                    <h1 style="font-size: 4rem; font-weight: bold; color: #1e3a5f; text-transform: uppercase;">MONKEY'S</h1>
                </div>
                <p style="margin-top: 2rem; color: #6b7280; font-size: 1.125rem;">Join Us Today!</p>
            </div>
        </div>
        
        <!-- Right Side - Dark Blue Form (40%) -->
        <div style="flex: 0 0 40%; background-color: #1e3a5f; color: white; display: flex; flex-direction: column; padding: 2rem;">
            <div style="max-width: 500px; margin: 0 auto; width: 100%; display: flex; flex-direction: column; justify-content: center; min-height: 100%;">
                <!-- Header -->
                <div style="margin-bottom: 2rem;">
                    <h1 style="font-size: 1.75rem; font-weight: bold; text-transform: uppercase; margin-bottom: 0.5rem;">SIX MONKEY'S</h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">
                        Sudah memiliki akun? 
                        <a href="{{ route('login') }}" style="color: white; text-decoration: underline;">Login disini</a>
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Nama</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            required
                            value="{{ old('name') }}"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.25rem; border: none; font-size: 1rem; box-sizing: border-box;"
                            class="@error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <p style="color: #fca5a5; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Email</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required
                            value="{{ old('email') }}"
                            style="width: 100%; padding: 0.75rem; border-radius: 0.25rem; border: none; font-size: 1rem; box-sizing: border-box;"
                            class="@error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p style="color: #fca5a5; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Kata Sandi</label>
                        <div style="position: relative;">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required
                                style="width: 100%; padding: 0.75rem 3rem 0.75rem 0.75rem; border-radius: 0.25rem; border: none; font-size: 1rem; box-sizing: border-box;"
                                class="@error('password') border-red-500 @enderror"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280;"
                            >
                                <svg id="eye-password" style="width: 1.25rem; height: 1.25rem; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-password" style="width: 1.25rem; height: 1.25rem; display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p style="color: #fca5a5; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Konfirmasi Kata Sandi</label>
                        <div style="position: relative;">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required
                                style="width: 100%; padding: 0.75rem 3rem 0.75rem 0.75rem; border-radius: 0.25rem; border: none; font-size: 1rem; box-sizing: border-box;"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation')"
                                style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280;"
                            >
                                <svg id="eye-password_confirmation" style="width: 1.25rem; height: 1.25rem; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-password_confirmation" style="width: 1.25rem; height: 1.25rem; display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        style="width: 100%; padding: 0.75rem; background-color: white; color: #1e3a5f; border: none; border-radius: 0.25rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: opacity 0.3s;"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'"
                    >
                        Daftar
                    </button>
                </form>

                <!-- Login Link -->
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.8); text-decoration: underline; font-size: 0.875rem;">Sudah Punya Akun?</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-' + fieldId);
            const eyeOffIcon = document.getElementById('eye-off-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                if (eyeIcon) eyeIcon.style.display = 'none';
                if (eyeOffIcon) eyeOffIcon.style.display = 'block';
            } else {
                field.type = 'password';
                if (eyeIcon) eyeIcon.style.display = 'block';
                if (eyeOffIcon) eyeOffIcon.style.display = 'none';
            }
        }
    </script>
</body>
</html>
