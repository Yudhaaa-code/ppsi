@extends('layouts.dashboard')

@section('title', 'Customer Dashboard')

@section('content')
<div class="min-h-screen -mt-16">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-blue-800 text-white">
        <div class="relative">
            <div class="flex">
                <!-- Sidebar -->
                <aside class="w-64 px-8 py-10">
                    <div class="mb-8">
                        <!-- sidebar brand removed (logo moved to top) -->
                    </div>
                    <nav class="space-y-4">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 text-slate-200 bg-white/10 rounded-md px-3 py-2 shadow-md">
                            <span class="bg-slate-800/60 p-2 rounded-md flex items-center justify-center">
                                <!-- precise home icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 3.3l8 6.2V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1V9.5l8-6.2z" fill="currentColor" />
                                    <rect x="9" y="13" width="6" height="6" rx="1" fill="#071133" opacity="0.12" />
                                </svg>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('customer.transactions') }}" class="flex items-center gap-3 text-slate-200">
                            <span class="bg-transparent p-2 rounded-md flex items-center justify-center">
                                <!-- stable clock icon (Heroicons-style) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                            </span>
                            <span class="font-medium">Riwayat Transaksi</span>
                        </a>
                    </nav>
                </aside>

                <!-- Main -->
                <main class="flex-1 px-16 py-10">
                    <div class="flex items-start gap-8">
                        <div class="w-72 bg-blue-500 rounded-xl p-6 shadow-lg">
                            <div class="mt-1 text-lg font-semibold">{{ Auth::user()->name }}</div>
                            <hr class="my-4 border-white/30">
                            <div class="flex items-center gap-3 text-sm text-blue-100">
                                <span class="text-white/90 text-lg leading-none">📞</span>
                                <span>{{ Auth::user()->phone ?? '0812345678' }}</span>
                            </div>
                        </div>

                        <div class="w-72 bg-blue-500 rounded-xl p-6 shadow-lg">
                            <div class="mt-4 text-lg font-semibold">Rp {{ number_format($balanceRobux ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-10 text-center">
                        <h2 class="text-lg font-semibold">Jumlah Transaksi Hari Ini</h2>
                        <div class="mt-6 flex justify-center items-center gap-6">
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
                        <div class="mt-4 text-sm text-white/90">
                            <div class="grid grid-cols-6 gap-4 font-medium border-b border-white/20 pb-3">
                                <div>ID Roblox</div>
                                <div>Robux</div>
                                <div>Inputan/ID</div>
                                <div>Harga</div>
                                <div>Tanggal</div>
                                <div>Status</div>
                            </div>
                            <div class="mt-6 text-sm text-white/70">Belum ada transaksi hari ini.</div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@endsection

