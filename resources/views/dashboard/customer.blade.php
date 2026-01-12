<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Dashboard - Six Monkeys</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-blue-800 text-white">
        <div class="relative">
            <div class="flex flex-col md:flex-row min-h-screen">
                <!-- Sidebar -->
                <aside class="w-full md:w-64 px-4 md:px-8 py-6 md:py-10">
                    <div class="mb-8 pl-3">
                        <a href="/" class="text-2xl font-bold uppercase tracking-wider hover:text-blue-200 transition">SIX MONKEY'S</a>
                    </div>
                    <nav class="space-y-4">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 text-slate-200 bg-white/10 rounded-md px-3 py-2 shadow-md">
                            <span class="bg-slate-800/60 p-2 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 3.3l8 6.2V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1V9.5l8-6.2z" fill="currentColor" />
                                    <rect x="9" y="13" width="6" height="6" rx="1" fill="#071133" opacity="0.12" />
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('customer.transactions') }}" class="flex items-center gap-3 text-slate-200 hover:bg-white/5 rounded-md px-3 py-2 transition">
                            <span class="bg-transparent p-2 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                            </span>
                            <span class="font-medium">Riwayat Transaksi</span>
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-8 pt-8 border-t border-white/10">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 text-slate-200 hover:bg-red-500/20 hover:text-red-200 rounded-md px-3 py-2 transition">
                                <span class="p-2 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </span>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </nav>
                </aside>

                <!-- Main -->
                <main class="flex-1 px-4 md:px-16 py-6 md:py-10">
                    <div class="flex flex-col md:flex-row items-start gap-4 md:gap-8">
                        <div class="w-full md:w-72 bg-blue-500 rounded-xl p-6 shadow-lg">
                            <div class="mt-1 text-lg font-semibold">{{ Auth::user()->name }}</div>
                            <hr class="my-4 border-white/30">
                            <div class="flex items-center gap-3 text-sm text-blue-100">
                                <span class="text-white/90 text-lg leading-none">📞</span>
                                <span>{{ Auth::user()->phone ?? '0812345678' }}</span>
                            </div>
                        </div>

                        <div class="w-full md:w-72 bg-blue-500 rounded-xl p-6 shadow-lg">
                            <div class="mt-4 text-lg font-semibold">Rp {{ number_format($balanceRobux ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-10 text-center">
                        <h2 class="text-lg font-semibold">Jumlah Transaksi Hari Ini</h2>
                        <div class="mt-6 flex flex-wrap justify-center items-center gap-4 md:gap-6">
                            <div class="w-20 h-20 bg-blue-400 rounded-lg flex flex-col items-center justify-center shadow">
                                <div class="text-2xl font-bold">0</div>
                                <div class="text-xs mt-1">Total</div>
                            </div>
                            <div class="w-20 h-20 bg-blue-400 rounded-lg flex flex-col items-center justify-center shadow">
                                <div class="text-2xl font-bold">0</div>
                                <div class="text-xs mt-1">Dalam Proses</div>
                            </div>
                            <div class="w-20 h-20 bg-blue-400 rounded-lg flex flex-col items-center justify-center shadow">
                                <div class="text-2xl font-bold">0</div>
                                <div class="text-xs mt-1">Sukses</div>
                            </div>
                            <div class="w-20 h-20 bg-blue-400 rounded-lg flex flex-col items-center justify-center shadow">
                                <div class="text-2xl font-bold">0</div>
                                <div class="text-xs mt-1">Gagal</div>
                            </div>
                            <div class="w-20 h-20 bg-blue-400 rounded-lg flex flex-col items-center justify-center shadow">
                                <div class="text-2xl font-bold">0</div>
                                <div class="text-xs mt-1">Batal</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h3 class="text-lg font-semibold">Riwayat Transaksi Terbaru Hari Ini</h3>
                        <div class="mt-4 text-sm text-white/90 overflow-x-auto">
                            <div class="grid grid-cols-6 gap-4 font-medium border-b border-white/20 pb-3 min-w-[600px]">
                                <div>ID Roblox</div>
                                <div>Robux</div>
                                <div>Inputan/ID</div>
                                <div>Harga</div>
                                <div>Tanggal</div>
                                <div>Status</div>
                            </div>
                            <div class="mt-6 text-sm text-white/70 min-w-[600px]">Belum ada transaksi hari ini.</div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>