<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Six Monkey's</title>
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

<div class="flex relative">
    <!-- Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/80 z-40 hidden transition-opacity backdrop-blur-sm md:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 min-h-screen p-6 bg-[#081f3f] transform -translate-x-full transition-transform duration-300 md:translate-x-0 md:static md:block shadow-2xl md:shadow-none border-r border-white/10 md:border-none">
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
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
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
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-bold">Edit User</h2>
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

        <!-- Edit Form -->
        <div class="bg-black/30 rounded-xl p-4 md:p-6 max-w-2xl">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-300"
                               required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-300"
                               required>
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium mb-2">Role</label>
                        <select name="role" id="role" 
                                class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                            <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="developer" {{ old('role', $user->role) == 'developer' ? 'selected' : '' }}>Developer</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">Status</label>
                        <select name="status" id="status" 
                                class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                            <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition font-medium">
                            Update User
                        </button>
                        <a href="{{ route('users.index') }}" 
                           class="px-6 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition font-medium">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>
