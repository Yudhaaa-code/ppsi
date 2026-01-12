<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Six Monkeys</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-blue-900 to-blue-800 text-white">
    <div class="min-h-screen">
        <nav class="bg-transparent relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                                        <a href="{{ url('/') }}" class="text-xl font-bold text-white">Six Monkeys</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @php
                            $name = Auth::user()->name ?? '';
                            $parts = preg_split('/\s+/', trim($name));
                            $initials = strtoupper((isset($parts[0]) ? substr($parts[0],0,1) : '') . (isset($parts[1]) ? substr($parts[1],0,1) : (isset($parts[0][1]) ? substr($parts[0],1,1) : '')));
                        @endphp
                        <div class="w-9 h-9 bg-white text-slate-900 rounded-full flex items-center justify-center font-semibold">{{ $initials }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-white hover:text-white/80">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="w-full py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>

