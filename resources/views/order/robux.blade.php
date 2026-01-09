@extends('layouts.app')

@section('title', 'Order Robux - Six Monkeys')

@section('content')
<div class="bg-[#0f172a] min-h-screen text-white font-sans pt-16">
    <!-- Navbar -->
    <nav class="bg-[#0f172a] border-b border-gray-700 fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <span class="text-2xl font-bold tracking-wider">SIX MONKEY'S</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Riwayat Transaksi</a>
                        <a href="{{ route('register') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign Up</a>
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Image Placeholder -->
    <div class="bg-gray-400 h-64 flex items-center justify-center">
        <svg class="h-24 w-24 text-black" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
        </svg>
    </div>

    <!-- Info Bar -->
    <div class="bg-[#0f172a] py-4 border-b border-gray-700">
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Instructions -->
            <div class="lg:col-span-1 space-y-6 text-sm lg:sticky lg:top-20 lg:self-start">
                <div>
                    <h3 class="font-bold mb-2">Langkah-langkah membeli Roblox - Voucher :</h3>
                    <ol class="list-decimal pl-4 space-y-1 text-gray-300">
                        <li>Pilih jumlah Voucher yang diinginkan</li>
                        <li>Pilih metode pembayaran yang diinginkan</li>
                        <li>Masukkan nomor Whatsapp Anda yang AKTIF dengan benar</li>
                        <li>Klik Order Now dan selesaikan pembayaran</li>
                        <li>Silahkan menunggu beberapa saat, Roblox Voucher Code akan muncul di halaman invoice</li>
                    </ol>
                </div>

                <div>
                    <h3 class="font-bold mb-2">Langkah-langkah redeem voucher Roblox :</h3>
                    <ol class="list-decimal pl-4 space-y-1 text-gray-300">
                        <li>Buka browser www.sixmonkeys.com</li>
                        <li>Log in ke akun Roblox Anda yang ingin digunakan untuk voucher</li>
                        <li>Masukkan kode voucher yang Anda miliki</li>
                        <li>Klik "Redeem" untuk memproses voucher</li>
                        <li>Setelah credit ditambahkan, Anda bisa mengonversinya menjadi Robux dengan memilih opsi "Dapatkan Robux" atau "Konversikan Dana menjadi Robux" di bawah tombol Redeem</li>
                        <li>Pilih opsi untuk konversi atau beli Robux menggunakan saldo yang ada</li>
                    </ol>
                </div>

                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                    <p class="font-bold text-xs">⚠️ Jika terdapat kendala, silahkan hubungi Admin di Whatsapp resmi kami <a href="#" class="underline">DISINI</a>. ⚠️</p>
                </div>
            </div>

            <!-- Right Column: Order Form -->
            <div class="lg:col-span-2 space-y-4">
                <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                    @csrf
                    
                    <!-- Section 1 -->
                    <div class="bg-[#38bdf8] rounded-lg p-4 text-black mb-4">
                        <h3 class="font-bold text-lg mb-2">1. Masukkan Data Akun Anda</h3>
                        <input type="text" name="account_data" required placeholder="Masukkan Data Akun Anda" class="w-full p-2 rounded border-none focus:ring-2 focus:ring-blue-500">
                    </div>
    
                    <!-- Section 2 -->
                    <div class="bg-[#38bdf8] rounded-lg p-4 text-black mb-4">
                        <h3 class="font-bold text-lg mb-4">2. Pilih Nominal yang Ingin Anda Beli</h3>
                        <h4 class="font-bold mb-2">Voucher</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="voucher-container">
                            <input type="hidden" name="voucher_price" id="voucher_price" value="">
                            <input type="hidden" name="voucher_name" id="voucher_name" value="">
                            
                            <!-- Voucher Cards -->
                            @php
                                $vouchers = [
                                    ['name' => '80 Robux', 'price' => 10000],
                                    ['name' => '400 Robux', 'price' => 50000],
                                    ['name' => '800 Robux', 'price' => 100000],
                                    ['name' => '1200 Robux', 'price' => 150000],
                                    ['name' => '1700 Robux', 'price' => 200000],
                                    ['name' => '4500 Robux', 'price' => 500000],
                                ];
                            @endphp
                            
                            @foreach ($vouchers as $voucher)
                            <div class="voucher-card bg-[#3b82f6] hover:bg-blue-700 text-white p-3 rounded cursor-pointer transition border-2 border-transparent"
                                 data-price="{{ $voucher['price'] }}"
                                 data-name="{{ $voucher['name'] }}">
                                <div class="font-bold text-sm">{{ $voucher['name'] }}</div>
                                <div class="text-xs opacity-75">Rp {{ number_format($voucher['price'], 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
    
                    <!-- Section 3 -->
                    <div class="bg-[#38bdf8] rounded-lg p-4 text-black mb-4">
                        <h3 class="font-bold text-lg mb-2">3. Masukkan Jumlah Total</h3>
                        <div class="flex items-center gap-2">
                            <input type="number" name="quantity" id="quantity" value="1" min="1" class="flex-1 p-2 rounded border-none focus:ring-2 focus:ring-blue-500 text-center" readonly>
                            <button type="button" id="btn-plus" class="bg-[#3b82f6] text-white p-2 rounded w-10 h-10 flex items-center justify-center font-bold text-xl hover:bg-blue-700 transition select-none">+</button>
                            <button type="button" id="btn-minus" class="bg-[#3b82f6] text-white p-2 rounded w-10 h-10 flex items-center justify-center font-bold text-xl hover:bg-blue-700 transition select-none">-</button>
                        </div>
                    </div>
    
                    <!-- Section 4 -->
                    <div class="bg-[#38bdf8] rounded-lg p-4 text-black mb-4">
                        <h3 class="font-bold text-lg mb-4">4. Pilih Metode Pembayaran</h3>
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                        
                        <h4 class="font-bold mb-2">Transfer Bank</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4 payment-container">
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="BCA">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">BCA</div>
                                    <div class="text-[10px]">Verifikasi Otomatis 1-5 Menit</div>
                                    <div class="text-[10px]">(Open 24 Jam)</div>
                                </div>
                            </div>
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="Mandiri">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">Mandiri</div>
                                    <div class="text-[10px]">Verifikasi Otomatis 1-5 Menit</div>
                                    <div class="text-[10px]">(Open 24 Jam)</div>
                                </div>
                            </div>
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="BRI">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">BRI</div>
                                    <div class="text-[10px]">Verifikasi Otomatis 1-5 Menit</div>
                                    <div class="text-[10px]">(Open 24 Jam)</div>
                                </div>
                            </div>
                        </div>
    
                        <h4 class="font-bold mb-2">E - Wallet</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 payment-container">
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="DANA">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">DANA</div>
                                    <div class="text-[10px]">Verifikasi Otomatis (Open 24 Jam)</div>
                                </div>
                            </div>
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="GOPAY">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GOPAY" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">GOPAY</div>
                                    <div class="text-[10px]">Verifikasi Otomatis (Open 24 Jam)</div>
                                </div>
                            </div>
                            <div class="payment-card bg-[#3b82f6] p-3 rounded cursor-pointer hover:bg-blue-700 transition border-2 border-transparent flex flex-col justify-between min-h-[100px]" data-method="QRIS">
                                <div class="mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-6 bg-white rounded px-1">
                                </div>
                                <div>
                                    <div class="font-bold">QRIS</div>
                                    <div class="text-[10px]">Verifikasi Otomatis (Open 24 Jam)</div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Section 5 -->
                    <div class="bg-[#38bdf8] rounded-lg p-4 text-black mb-4">
                        <h3 class="font-bold text-lg mb-2">5. No. Whatsapp</h3>
                        <input type="text" name="whatsapp_number" required placeholder="Masukkan Nomor Whatsapp Anda" class="w-full p-2 rounded border-none focus:ring-2 focus:ring-blue-500 mb-1">
                        <p class="text-xs text-gray-700">Nomor ini akan dihubungi jika ada masalah</p>
                    </div>

                    <!-- Total Price Display -->
                    <div class="bg-[#1e293b] rounded-lg p-4 text-white mb-4 border border-gray-600">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total Pembayaran:</span>
                            <span id="total-price-display" class="text-2xl font-bold text-[#38bdf8]">Rp 0</span>
                        </div>
                    </div>
    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#38bdf8] hover:bg-sky-500 text-black font-bold py-3 rounded-lg text-lg transition shadow-lg transform active:scale-95">
                        Pesan Sekarang!
                    </button>
                </form>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const orderForm = document.getElementById('orderForm');
                    const voucherCards = document.querySelectorAll('.voucher-card');
                    const paymentCards = document.querySelectorAll('.payment-card');
                    const quantityInput = document.getElementById('quantity');
                    const btnPlus = document.getElementById('btn-plus');
                    const btnMinus = document.getElementById('btn-minus');
                    const totalPriceDisplay = document.getElementById('total-price-display');
                    const voucherPriceInput = document.getElementById('voucher_price');
                    const voucherNameInput = document.getElementById('voucher_name');
                    const paymentMethodInput = document.getElementById('payment_method');
                    
                    let selectedPrice = 0;
                    let quantity = 1;
                    
                    // Helper function to format currency
                    function formatRupiah(amount) {
                        return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                    
                    function updateTotal() {
                        const total = selectedPrice * quantity;
                        totalPriceDisplay.textContent = formatRupiah(total);
                    }

                    // Handle Form Submission
                    orderForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        // Basic Validation
                        if (!voucherPriceInput.value) {
                            alert('Silahkan pilih voucher terlebih dahulu!');
                            return;
                        }
                        if (!paymentMethodInput.value) {
                            alert('Silahkan pilih metode pembayaran!');
                            return;
                        }

                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalBtnText = submitBtn.innerText;
                        
                        try {
                            submitBtn.innerText = 'Memproses...';
                            submitBtn.disabled = true;

                            const response = await fetch("{{ route('order.store') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const result = await response.json();

                            if (result.status === 'success') {
                                // Redirect to payment page
                                window.location.href = result.redirect_url;
                            } else {
                                alert('Gagal memproses pesanan: ' + (result.message || 'Unknown error'));
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan sistem');
                        } finally {
                            submitBtn.innerText = originalBtnText;
                            submitBtn.disabled = false;
                        }
                    });
                    
                    // Voucher Selection
                    voucherCards.forEach(card => {
                        card.addEventListener('click', function() {
                            // Remove active class from all
                            voucherCards.forEach(c => {
                                c.classList.remove('ring-4', 'ring-yellow-400', 'bg-blue-800');
                                c.classList.add('bg-[#3b82f6]');
                            });
                            
                            // Add active class to clicked
                            this.classList.remove('bg-[#3b82f6]');
                            this.classList.add('ring-4', 'ring-yellow-400', 'bg-blue-800');
                            
                            // Update values
                            selectedPrice = parseInt(this.getAttribute('data-price'));
                            const name = this.getAttribute('data-name');
                            
                            voucherPriceInput.value = selectedPrice;
                            voucherNameInput.value = name;
                            
                            updateTotal();
                        });
                    });
                    
                    // Payment Selection
                    paymentCards.forEach(card => {
                        card.addEventListener('click', function() {
                            // Remove active class from all
                            paymentCards.forEach(c => {
                                c.classList.remove('ring-4', 'ring-yellow-400', 'bg-blue-800');
                                c.classList.add('bg-[#3b82f6]');
                            });
                            
                            // Add active class to clicked
                            this.classList.remove('bg-[#3b82f6]');
                            this.classList.add('ring-4', 'ring-yellow-400', 'bg-blue-800');
                            
                            // Update value
                            paymentMethodInput.value = this.getAttribute('data-method');
                        });
                    });
                    
                    // Quantity Controls
                    btnPlus.addEventListener('click', function() {
                        quantity++;
                        quantityInput.value = quantity;
                        updateTotal();
                    });
                    
                    btnMinus.addEventListener('click', function() {
                        if (quantity > 1) {
                            quantity--;
                            quantityInput.value = quantity;
                            updateTotal();
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
