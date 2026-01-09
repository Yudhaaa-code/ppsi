@extends('layouts.app')

@section('title', 'Payment - Six Monkeys')

@section('content')
<div class="bg-[#0f172a] min-h-screen text-white font-sans pt-16">
    <!-- Navbar (Simplified or same as app) -->
    <nav class="bg-[#0f172a] border-b border-gray-700 fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <span class="text-2xl font-bold tracking-wider">SIX MONKEY'S</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Riwayat Transaksi</a>
                        <a href="{{ route('register') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign Up</a>
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Info Bar -->
    <div class="bg-[#0f172a] py-4 border-b border-gray-700 mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center text-sm md:text-base">
            <div class="mb-2 md:mb-0">
                <div class="font-bold">Roblox - Voucher</div>
                <div class="text-gray-400">Roblox Corporation</div>
            </div>
            <div class="flex items-center gap-2 mb-2 md:mb-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Jam Operasional : 10.00 - 23.00</span>
            </div>
            <div class="mb-2 md:mb-0">Proses : 1 - 3 Menit</div>
            <div>Lokasi : Indonesia</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Left Column: Status & QR/VA -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-[#38bdf8] rounded-lg p-6 text-black text-center shadow-lg">
                    <h2 class="font-bold text-xl mb-2">Menunggu Pembayaran</h2>
                    <p class="text-sm mb-4">Selesaikan Pembayaran Sebelum Waktu Habis</p>
                    
                    <div class="flex justify-center gap-4 text-2xl font-bold" id="countdown">
                        <div class="flex flex-col items-center">
                            <span id="hours">00</span>
                            <span class="text-xs font-normal">Jam</span>
                        </div>
                        <span>:</span>
                        <div class="flex flex-col items-center">
                            <span id="minutes">00</span>
                            <span class="text-xs font-normal">Menit</span>
                        </div>
                        <span>:</span>
                        <div class="flex flex-col items-center">
                            <span id="seconds">00</span>
                            <span class="text-xs font-normal">Detik</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code or VA Display -->
                <div class="bg-[#38bdf8] rounded-lg p-6 text-black text-center shadow-lg flex flex-col items-center justify-center min-h-[300px]">
                    @if($payment_type == 'qris' || $payment_type == 'gopay')
                        <h3 class="font-bold text-xl mb-4">Scan QR</h3>
                        @if(isset($qr_url))
                            <img src="{{ $qr_url }}" alt="QR Code" class="bg-white p-2 rounded-lg w-48 h-48">
                        @else
                            <div class="bg-white p-4 rounded text-red-500">QR Code Error</div>
                        @endif
                    @elseif(in_array($payment_type, ['bank_transfer', 'echannel', 'bca_va', 'bri_va', 'bni_va']))
                        <h3 class="font-bold text-xl mb-4">Virtual Account</h3>
                        <div class="bg-white p-6 rounded-lg w-full">
                            <p class="text-gray-500 text-sm mb-1">Nomor Virtual Account</p>
                            <div class="text-2xl font-bold tracking-wider mb-2 select-all">{{ $va_number ?? '-' }}</div>
                            <p class="text-gray-500 text-sm mb-1">Bank</p>
                            <div class="font-bold uppercase">{{ $bank ?? 'Bank' }}</div>
                        </div>
                    @else
                        <h3 class="font-bold text-xl mb-4">Instruksi Pembayaran</h3>
                        <p>Silahkan selesaikan pembayaran sesuai metode yang dipilih.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Payment Details -->
            <div class="space-y-6">
                <div class="bg-[#38bdf8] rounded-lg p-6 text-black shadow-lg">
                    <h2 class="font-bold text-xl mb-4">Pembayaran</h2>
                    
                    <div class="bg-white rounded-lg p-6 space-y-3">
                        <div>
                            <span class="font-bold block">Nomor Pesanan:</span>
                            <span>{{ $order_number }}</span>
                        </div>
                        @if(isset($va_number))
                        <div>
                            <span class="font-bold block">Virtual Account:</span>
                            <span class="select-all">{{ $va_number }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="font-bold block">Katalog:</span>
                            <span>{{ $item_name }}</span>
                        </div>
                        <div>
                            <span class="font-bold block">Total Pembayaran:</span>
                            <span class="text-lg">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    // Simple Countdown Timer
    // Assuming expiry_time is passed as a timestamp or we set a fixed 24h
    const expiryTime = {{ $expiry_time ?? (time() + 24*60*60) }} * 1000; // PHP time to JS ms

    function updateTimer() {
        const now = new Date().getTime();
        const distance = expiryTime - now;

        if (distance < 0) {
            document.getElementById("countdown").innerHTML = "EXPIRED";
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
        document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
    }

    setInterval(updateTimer, 1000);
    updateTimer();
</script>
@endsection
