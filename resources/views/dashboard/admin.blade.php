<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Six Monkey's</title>
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

<?php
$totalPendapatan = $totalRevenue ?? 0;
$statistik = [
    'total' => $totalOrders ?? 0,
    'proses' => $pendingOrders ?? 0,
    'sukses' => $completedOrders ?? 0,
    'gagal' => $failedOrders ?? 0,
    'batal' => $cancelledOrders ?? 0,
];
?>

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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                <span>🏠</span>
                <span>Dashboard Admin</span>
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
                <span>👥</span>
                <span>Manage Users</span>
            </a>
            <a href="{{ route('admin.robux') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/10 transition">
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
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
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

        <div class="flex flex-col md:flex-row gap-6 mb-10">
            <div class="inline-block bg-blue-600/80 px-8 py-5 rounded-xl shadow-lg w-full md:w-auto">
                <p class="text-sm opacity-80">Total Pendapatan</p>
                <p class="text-xl font-bold mt-1">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></p>
            </div>
            
            <a href="{{ route('users.index') }}" class="inline-block bg-purple-600/80 px-8 py-5 rounded-xl shadow-lg hover:bg-purple-700/80 transition w-full md:w-auto">
                <p class="text-sm opacity-80">Manage Users</p>
                <p class="text-xl font-bold mt-1">Total User: <?= number_format($totalUsers ?? 0, 0, ',', '.') ?></p>
                <p class="text-xs opacity-70 mt-2">Klik untuk mengelola data pengguna</p>
            </a>
        </div>

        <h2 class="text-lg font-semibold mb-4">Jumlah Transaksi Robux Hari Ini</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-12">
            <div class="bg-blue-500/80 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold"><?= $statistik['total'] ?></p>
                <p class="text-sm opacity-80">Total</p>
            </div>
            <div class="bg-blue-500/80 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold"><?= $statistik['proses'] ?></p>
                <p class="text-sm opacity-80">Dalam Proses</p>
            </div>
            <div class="bg-blue-500/80 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold"><?= $statistik['sukses'] ?></p>
                <p class="text-sm opacity-80">Sukses</p>
            </div>
            <div class="bg-blue-500/80 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold"><?= $statistik['gagal'] ?></p>
                <p class="text-sm opacity-80">Gagal</p>
            </div>
            <div class="bg-blue-500/80 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold"><?= $statistik['batal'] ?></p>
                <p class="text-sm opacity-80">Batal</p>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <h2 class="text-lg font-semibold mb-4">Riwayat Transaksi Terbaru Hari Ini</h2>
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
                    <?php if (isset($recentOrders) && $recentOrders->count() > 0) { ?>
                        <?php foreach ($recentOrders as $order) { ?>
                        <tr>
                            <td class="py-2"><?= $order->username ?? 'N/A' ?></td>
                            <td class="py-2"><?= number_format($order->robux_amount ?? 0, 0, ',', '.') ?></td>
                            <td class="py-2"><?= $order->input_type ?? 'N/A' ?></td>
                            <td class="py-2">Rp <?= number_format($order->total_price ?? 0, 0, ',', '.') ?></td>
                            <td class="py-2"><?= $order->created_at->format('d/m/Y H:i') ?></td>
                            <td class="py-2">
                                <?php
                                $paymentStatus = $order->transactions()->latest()->first()->payment_status ?? 'pending';
                                $paymentClass = $paymentStatus == 'settlement' ? 'bg-green-500' : ($paymentStatus == 'pending' ? 'bg-yellow-500' : 'bg-red-500');
                                ?>
                                <span class="px-2 py-1 rounded text-xs <?= $paymentClass ?>">
                                    <?= ucfirst($paymentStatus) ?>
                                </span>
                            </td>
                            <td class="py-2">
                                <select onchange="updateManualStatus('<?= $order->id ?>', this.value)" class="px-2 py-1 rounded text-xs bg-blue-500 text-white border-none focus:outline-none focus:ring-1 focus:ring-blue-300">
                                    <option value="on progress" <?= $order->manual_status == 'on progress' ? 'selected' : '' ?>>On Progress</option>
                                    <option value="success" <?= $order->manual_status == 'success' ? 'selected' : '' ?>>Success</option>
                                    <option value="failed" <?= $order->manual_status == 'failed' ? 'selected' : '' ?>>Failed</option>
                                    <option value="cancelled" <?= $order->manual_status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="py-6 text-center">Belum ada transaksi</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
