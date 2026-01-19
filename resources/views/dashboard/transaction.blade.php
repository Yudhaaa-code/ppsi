<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Robux - Six Monkey's</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0B3C6D'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#081f3f] via-[#0b3c6d] to-[#06224a] text-white">

<!-- Mobile Header -->
<div class="md:hidden flex items-center justify-between p-4 bg-[#081f3f]/90 backdrop-blur-sm sticky top-0 z-30 border-b border-white/10">
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="text-white p-2 hover:bg-white/10 rounded-lg transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <h1 class="text-lg font-bold">SIX MONKEY'S</h1>
    </div>
    <div class="relative">
        <button onclick="toggleMobileDropdown()" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold hover:bg-white/30 transition">
            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
        </button>
        <!-- Mobile Dropdown Menu -->
        <div id="mobileProfileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
            <div class="px-4 py-2 text-gray-800 border-b border-gray-200">
                <p class="font-semibold text-sm">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <p class="text-xs text-gray-600">{{ Auth::user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div class="flex flex-col md:flex-row relative">
    <!-- Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/80 z-40 hidden transition-opacity backdrop-blur-sm md:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 min-h-screen p-6 bg-[#081f3f] md:bg-transparent transform -translate-x-full md:translate-x-0 transition-transform duration-300 md:relative shadow-2xl md:shadow-none border-r border-white/10 md:border-none">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('home') }}">
                <h1 class="text-xl font-bold hover:text-gray-300 transition">SIX MONKEY'S</h1>
            </a>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <span>🏠</span>
                <span>Dashboard Admin</span>
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <span>👥</span>
                <span>Manage Users</span>
            </a>
            <a href="{{ route('admin.robux') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                <span>🛒</span>
                <span>Pembelian Robux</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-10 min-w-0">
        <!-- Header -->
        <div class="flex justify-end mb-10 relative">
            <div class="relative hidden md:block">
                <button onclick="toggleDropdown()" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition cursor-pointer">
                    <span class="text-sm font-semibold">{{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}</span>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                    <div class="px-4 py-2 text-gray-800 border-b border-gray-200">
                        <p class="font-semibold text-sm">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-gray-600">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                
                if (!overlay.classList.contains('hidden')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }

            function toggleDropdown() {
                const dropdown = document.getElementById('profileDropdown');
                dropdown.classList.toggle('hidden');
            }

            function toggleMobileDropdown() {
                const dropdown = document.getElementById('mobileProfileDropdown');
                dropdown.classList.toggle('hidden');
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                // Desktop dropdown
                const dropdown = document.getElementById('profileDropdown');
                const button = event.target.closest('button');
                const isDropdownButton = button && button.getAttribute('onclick') === 'toggleDropdown()';
                
                if (!isDropdownButton && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }

                // Mobile dropdown
                const mobileDropdown = document.getElementById('mobileProfileDropdown');
                const isMobileButton = button && button.getAttribute('onclick') === 'toggleMobileDropdown()';
                
                if (!isMobileButton && !mobileDropdown.contains(event.target)) {
                    mobileDropdown.classList.add('hidden');
                }
            });
        </script>

        <script>
        function updateManualStatus(orderId, newStatus) {
            const statusText = newStatus === 'on progress' ? 'On Progress' : 
                             newStatus === 'success' ? 'Success' :
                             newStatus === 'failed' ? 'Failed' : 'Cancelled';
            
            if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${statusText}?`)) {
                fetch(`/admin/orders/${orderId}/manual-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        manual_status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status berhasil diperbarui!');
                        location.reload();
                    } else {
                        alert('Gagal memperbarui status: ' + data.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error.message);
                    location.reload();
                });
            } else {
                location.reload();
            }
        }
        </script>

        <!-- Transaksi Robux -->
        <h2 class="text-lg font-semibold mb-4">Transaksi Robux</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.robux') }}" class="mb-6 flex flex-wrap gap-4 items-end bg-black/20 p-4 rounded-xl">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium mb-1">Cari ID Roblox</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Username..." 
                       class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <select name="status" id="status" class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white [&>option]:bg-[#081f3f]">
                    <option value="">Semua Status</option>
                    <option value="on progress" {{ request('status') == 'on progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Payment Status -->
            <div>
                <label for="payment_status" class="block text-sm font-medium mb-1">Pembayaran</label>
                <select name="payment_status" id="payment_status" class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white [&>option]:bg-[#081f3f]">
                    <option value="">Semua Pembayaran</option>
                    <option value="settlement" {{ request('payment_status') == 'settlement' ? 'selected' : '' }}>Settlement (Paid)</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="expire" {{ request('payment_status') == 'expire' ? 'selected' : '' }}>Expire</option>
                    <option value="cancel" {{ request('payment_status') == 'cancel' ? 'selected' : '' }}>Cancel</option>
                    <option value="deny" {{ request('payment_status') == 'deny' ? 'selected' : '' }}>Deny</option>
                </select>
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}" 
                       class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white [color-scheme:dark]">
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.robux') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition font-medium flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="bg-black/30 rounded-xl p-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="border-b border-white/20">
                    <tr class="text-left">
                        <th class="py-2">ID Roblox</th>
                        <th class="py-2">Robux</th>
                        <th class="py-2">Inputan</th>
                        <th class="py-2">Harga</th>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Pembayaran</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="opacity-70">
                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                        <tr>
                            <td class="py-2">{{ $order->username ?? 'N/A' }}</td>
                            <td class="py-2">{{ number_format($order->robux_amount ?? 0, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $order->input_type ?? 'N/A' }}</td>
                            <td class="py-2">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2">
                                @php
                                $paymentStatus = $order->transactions()->latest()->first()->payment_status ?? 'pending';
                                $paymentClass = $paymentStatus == 'settlement' ? 'bg-green-500' : ($paymentStatus == 'pending' ? 'bg-yellow-500' : 'bg-red-500');
                                @endphp
                                <span class="px-2 py-1 rounded text-xs {{ $paymentClass }}">
                                    {{ ucfirst($paymentStatus) }}
                                </span>
                            </td>
                            <td class="py-2">
                                <select onchange="updateManualStatus('{{ $order->id }}', this.value)" class="px-2 py-1 rounded text-xs bg-blue-500 text-white border-none focus:outline-none focus:ring-1 focus:ring-blue-300">
                                    <option value="on progress" {{ $order->manual_status == 'on progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="success" {{ $order->manual_status == 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="failed" {{ $order->manual_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="cancelled" {{ $order->manual_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-6 text-center">Belum ada transaksi</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if(isset($recentOrders) && method_exists($recentOrders, 'links'))
            <div class="mt-4">
                {!! $recentOrders->links() !!}
            </div>
        @endif
    </main>
</div>

</body>
</html>