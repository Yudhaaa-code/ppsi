<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - Six Monkeys</title>
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
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 text-slate-200 hover:bg-white/5 rounded-md px-3 py-2 transition">
                            <span class="bg-transparent p-2 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 3.3l8 6.2V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1V9.5l8-6.2z" fill="currentColor" />
                                    <rect x="9" y="13" width="6" height="6" rx="1" fill="#071133" opacity="0.12" />
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('customer.transactions') }}" class="flex items-center gap-3 text-slate-200 bg-white/10 rounded-md px-3 py-2 shadow-md">
                            <span class="bg-slate-800/60 p-2 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
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
                    <h1 class="text-2xl font-semibold text-white mb-6">Riwayat Transaksi</h1>

                    <div class="bg-white/5 rounded-lg p-6 border border-white/20">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-center">
                            <div>
                                <label class="text-sm text-white/80 block mb-1">Status</label>
                                <select class="w-full bg-transparent border border-white/20 rounded px-3 py-2 text-white [&>option]:text-black">
                                    <option>Semua</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm text-white/80 block mb-1">Status Pembayaran</label>
                                <select class="w-full bg-transparent border border-white/20 rounded px-3 py-2 text-white [&>option]:text-black">
                                    <option>Semua</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm text-white/80 block mb-1">Tanggal Mulai</label>
                                <div class="relative">
                                    <input type="text" placeholder="dd/mm/yyyy" class="w-full bg-transparent border border-white/20 rounded px-3 pr-10 h-10 text-white placeholder-white/50" />
                                    <span class="absolute inset-y-0 right-3 flex items-center text-white/60 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" />
                                            <path d="M16 3v4M8 3v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm text-white/80 block mb-1">Tanggal Akhir</label>
                                <div class="relative">
                                    <input type="text" placeholder="dd/mm/yyyy" class="w-full bg-transparent border border-white/20 rounded px-3 pr-10 h-10 text-white placeholder-white/50" />
                                    <span class="absolute inset-y-0 right-3 flex items-center text-white/60 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" />
                                            <path d="M16 3v4M8 3v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-white/90 overflow-x-auto">
                        <div class="min-w-[800px]">
                            <div class="grid grid-cols-6 gap-4 font-medium border-b border-white/20 pb-3">
                                <div>Nomor Invoice</div>
                                <div>Robux</div>
                                <div>Inputan/ID</div>
                                <div>Harga</div>
                                <div>Tanggal</div>
                                <div>Status</div>
                            </div>
                            @if(isset($transactions) && $transactions->count())
                                @foreach($transactions as $t)
                                    <div class="grid grid-cols-6 gap-4 py-3 border-b border-white/5 items-center text-sm">
                                        <div class="truncate">{{ $t->invoice }}</div>
                                        <div>{{ $t->robux }}</div>
                                        <div class="truncate">{{ $t->input_id }}</div>
                                        <div>Rp {{ number_format($t->price, 0, ',', '.') }}</div>
                                        <div>{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y H:i') }}</div>
                                        <div>{{ ucfirst($t->status) }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mt-6 text-white/70">Belum ada transaksi.</div>
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>