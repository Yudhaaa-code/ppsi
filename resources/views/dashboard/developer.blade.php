<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Developer Board - SIX MONKEY'S</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <body class="min-h-screen bg-gradient-to-br from-[#081f3f] via-[#0b3c6d] to-[#06224a] text-white">
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-5">
        <div>
            <h1 class="text-white text-2xl font-bold uppercase tracking-wide">SIX MONKEY'S</h1>
        </div>
        <div class="flex items-center gap-3 text-white">
            
            <div class="flex items-center gap-2 ml-4">
                <span class="text-sm font-semibold">{{ ucfirst(Auth::user()->role ?? 'Developer') }}</span>
                <div class="w-10 h-10 rounded-full bg-white text-slate-900 flex items-center justify-center font-bold uppercase">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="border border-white text-white text-xs px-3 py-1 rounded hover:bg-white hover:text-slate-900 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Board Title -->
    <div class="px-6 text-white text-sm font-semibold tracking-wide">BOARD</div>

    <!-- Board Container -->
    <div class="px-6 py-5 overflow-x-auto">
        <div class="flex flex-col md:flex-row gap-5 w-full md:w-max items-start">
            <!-- Today List -->
            <div class="w-full md:w-80 md:min-w-[320px] bg-amber-100 rounded-lg p-3 flex-shrink-0 shadow transition-all duration-300">
                <div class="flex items-center justify-between mb-2 cursor-pointer md:cursor-default" onclick="toggleList('today-content', 'today-chevron')">
                    <h2 class="text-sm font-semibold text-amber-900 flex items-center gap-2">
                        Today
                        <span class="w-4 h-4 border border-amber-900/60 rounded-sm bg-white/40"></span>
                    </h2>
                    <div class="flex items-center gap-2">
                        <svg id="today-chevron" class="w-5 h-5 text-amber-900 md:hidden transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div class="hidden md:flex items-center gap-2">
                            <button class="p-1 hover:bg-amber-200 rounded" title="List view">
                                <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10" />
                                </svg>
                            </button>
                            <button class="p-1 hover:bg-amber-200 rounded" title="More">
                                <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="today-content" class="hidden md:block">
                    <!-- Cards container -->
                    <div id="today-cards" class="space-y-2 mb-2">
                        <!-- cards will be injected here -->
                    </div>

                    <!-- Add Card button -->
                    <button
                        id="btn-add-today"
                        class="w-full text-left text-xs text-amber-900 px-2 py-1 rounded hover:bg-amber-200">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- Weekly List -->
            <div class="w-full md:w-80 md:min-w-[320px] bg-sky-100 rounded-lg p-3 flex-shrink-0 shadow transition-all duration-300">
                <div class="flex items-center justify-between mb-2 cursor-pointer md:cursor-default" onclick="toggleList('weekly-content', 'weekly-chevron')">
                    <h2 class="text-sm font-semibold text-sky-900 flex items-center gap-2">
                        Weekly
                        <span class="w-4 h-4 border border-sky-900/60 rounded-sm bg-white/40"></span>
                    </h2>
                    <div class="flex items-center gap-2">
                        <svg id="weekly-chevron" class="w-5 h-5 text-sky-900 md:hidden transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div class="hidden md:flex items-center gap-2">
                            <button class="p-1 hover:bg-sky-200 rounded" title="List view">
                                <svg class="w-4 h-4 text-sky-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10" />
                                </svg>
                            </button>
                            <button class="p-1 hover:bg-sky-200 rounded" title="More">
                                <svg class="w-4 h-4 text-sky-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="weekly-content" class="hidden md:block">
                    <div id="week-cards" class="space-y-2 mb-2"></div>
                    <button
                        id="btn-add-weekly"
                        class="w-full text-left text-xs text-sky-900 px-2 py-1 rounded hover:bg-sky-200">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- Later List -->
            <div class="w-full md:w-80 md:min-w-[320px] bg-pink-100 rounded-lg p-3 flex-shrink-0 shadow transition-all duration-300">
                <div class="flex items-center justify-between mb-2 cursor-pointer md:cursor-default" onclick="toggleList('later-content', 'later-chevron')">
                    <h2 class="text-sm font-semibold text-rose-900 flex items-center gap-2">
                        Later
                        <span class="w-4 h-4 border border-rose-900/60 rounded-sm bg-white/40"></span>
                    </h2>
                    <div class="flex items-center gap-2">
                        <svg id="later-chevron" class="w-5 h-5 text-rose-900 md:hidden transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div class="hidden md:flex items-center gap-2">
                            <button class="p-1 hover:bg-pink-200 rounded" title="List view">
                                <svg class="w-4 h-4 text-rose-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10" />
                                </svg>
                            </button>
                            <button class="p-1 hover:bg-pink-200 rounded" title="More">
                                <svg class="w-4 h-4 text-rose-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="later-content" class="hidden md:block">
                    <div id="later-cards" class="space-y-2 mb-2"></div>
                    <button
                        id="btn-add-later"
                        class="w-full text-left text-xs text-rose-900 px-2 py-1 rounded hover:bg-pink-200">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- Add Another List Button -->
            <div class="w-full md:w-80 md:min-w-[320px] flex-shrink-0">
                <button class="w-full bg-emerald-300 rounded-lg px-3 py-3 text-left text-sm font-semibold text-emerald-900 hover:bg-emerald-200">
                    + Add Another List
                </button>
            </div>
        </div>
    </div>

    <!-- Main Card Modal (Frame 3) -->
    <div id="card-modal" class="fixed inset-0 bg-black/60 hidden z-40 backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-0 md:p-4">
            <div class="bg-[#1e1e1e] text-[#b6c2cf] rounded-none md:rounded-xl w-full max-w-[1180px] shadow-2xl relative min-h-screen md:min-h-0">
            <!-- Header bar -->
            <div class="sticky top-0 z-10 bg-[#1e1e1e] flex items-center justify-between px-4 md:px-6 py-4 border-b border-[#2c333a]">
                <div class="flex items-center gap-2 relative">
                    <button class="flex items-center gap-2 text-sm font-semibold text-[#b6c2cf] hover:bg-[#A6C5E229] px-2 py-1 rounded transition-colors pointer-events-none">
                        <span id="modal-list-name">Today</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <select id="list-select" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="document.getElementById('modal-list-name').innerText = this.options[this.selectedIndex].text">
                        <option value="today">Today</option>
                        <option value="weekly">Weekly</option>
                        <option value="later">Later</option>
                    </select>
                </div>
                <div class="flex items-center gap-4 text-[#9fadbc]">
                    <button class="hover:text-[#b6c2cf]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg></button>
                    <button class="hover:text-[#b6c2cf]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></button>
                    <button class="hover:text-[#b6c2cf]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg></button>
                    <button id="card-modal-close" class="hover:text-[#b6c2cf] hover:bg-[#A6C5E229] rounded-full p-1 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-[1fr_400px] gap-8 px-6 pb-8 pt-10 md:pt-6">
                <!-- Left main column (scrollable) -->
            <div class="space-y-6 md:overflow-y-auto md:max-h-[75vh] pr-2">
                <div class="pb-2">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <button id="btn-complete-modal" class="mt-2.5 w-6 h-6 rounded-full border border-[#9fadbc] flex items-center justify-center text-[#b6c2cf] text-xs font-bold flex-shrink-0" title="Mark complete"></button>
                                <div class="flex-1">
                                    <input id="card-title" type="text" class="mt-2 bg-transparent border-none text-xl font-bold text-[#b6c2cf] focus:ring-0 w-full p-0 placeholder-[#9fadbc]" value="selesaikan fitur anjing">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-10 flex flex-wrap gap-2">
                        <button id="btn-header-add" onclick="document.getElementById('popup-add-to-card').classList.remove('hidden')" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add
                        </button>
                        <button id="btn-header-checklist" onclick="showChecklist()" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Checklist
                        </button>
                        <button id="btn-header-attach" onclick="showAttach()" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Attachment
                        </button>
                    </div>
                    
                    <div class="pl-10 space-y-6">
                        <!-- Members & Dates Row -->
                        <div class="flex flex-wrap gap-6">
                            <!-- Members -->
                            <div class="space-y-1.5 hidden" id="members-display-section">
                                <h3 class="text-xs font-semibold text-[#9fadbc] uppercase tracking-wide">Members</h3>
                                <div id="members-list" class="flex items-center gap-1"></div>
                            </div>

                            <!-- Labels -->
                            <div class="space-y-1.5 hidden" id="labels-display-section">
                                <h3 class="text-xs font-semibold text-[#9fadbc] uppercase tracking-wide">Labels</h3>
                                <div id="labels-display-list" class="flex flex-wrap gap-1">
                                    <button class="w-8 h-8 rounded bg-[#2c333a] hover:bg-[#384148] flex items-center justify-center text-[#b6c2cf] transition-colors" onclick="showLabels()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Dates -->
                            <div class="space-y-1.5 hidden" id="dates-display-section">
                                <h3 class="text-xs font-semibold text-[#9fadbc] uppercase tracking-wide">Dates</h3>
                                <div class="flex items-center gap-1">
                                <div class="flex items-center gap-2 bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-2 py-1.5 rounded-[3px] text-sm font-medium transition-colors cursor-pointer" onclick="showDates()">
                                    <span class="w-4 h-4 border border-[#b6c2cf]/40 rounded-sm"></span>
                                    <span id="date-display-value">Jan 7 - Jan 8, 15:23</span>
                                    <span id="date-display-badge" class="bg-[#4bce97] text-[#1d2125] text-[10px] font-bold px-1.5 rounded-sm uppercase ml-1">Complete</span>
                                    <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 text-lg font-semibold text-[#b6c2cf]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                    Description
                                </div>
                                <button id="btn-desc-edit" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors">Edit</button>
                            </div>
                            <div class="pl-9">
                                <div id="desc-editor" class="space-y-2">
                                    <div id="desc-toolbar" class="hidden flex items-center gap-2 bg-[#22272b] border border-[#2c333a] rounded-[3px] px-2 py-1 text-xs">
                                        <button id="btn-desc-bold" class="px-2 py-1 rounded hover:bg-[#384148] font-semibold">B</button>
                                        <button id="btn-desc-italic" class="px-2 py-1 rounded hover:bg-[#384148] italic">I</button>
                                        <button id="btn-desc-code" class="px-2 py-1 rounded hover:bg-[#384148]">`</button>
                                        <button id="btn-desc-ul" class="px-2 py-1 rounded hover:bg-[#384148]">•</button>
                                        <button id="btn-desc-link" class="px-2 py-1 rounded hover:bg-[#384148]">🔗</button>
                                        <button id="btn-desc-image" class="px-2 py-1 rounded hover:bg-[#384148]">🖼️</button>
                                    </div>
                                    <textarea id="card-description" class="w-full bg-transparent border-none p-0 text-sm text-[#b6c2cf] placeholder-[#9fadbc] focus:ring-0 transition-all min-h-[80px] resize-none" placeholder="Add a more detailed description...">asuu</textarea>
                                    <div id="desc-actions" class="hidden flex items-center gap-2">
                                        <button id="btn-desc-save" class="px-3 py-1.5 rounded-[3px] bg-[#579dff] text-[#1d2125] hover:bg-[#85b8ff] text-sm font-semibold">Save</button>
                                        <button id="btn-desc-cancel" class="px-3 py-1.5 rounded-[3px] bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] text-sm">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Attachments Section -->
                    <div class="space-y-3 hidden" id="attachment-section">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 text-lg font-semibold text-[#b6c2cf]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    Attachments
                                </div>
                                <button onclick="showAttach()" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors">Add</button>
                            </div>
                            <div id="attach-list" class="space-y-2 pl-9"></div>
                            <!-- Hidden inputs for logic -->
                            <div class="flex gap-2 hidden">
                                <input id="attach-name" type="text" class="flex-1">
                                <input id="attach-url" type="text" class="flex-1">
                                <button id="btn-attach-add">Add</button>
                            </div>
                        </div>

                        <!-- Checklist Section -->
                        <div class="space-y-3 hidden" id="checklist-section">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 text-lg font-semibold text-[#b6c2cf]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Checklist
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors">Hide checked items</button>
                                    <button class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors">Delete</button>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="flex items-center gap-3 pl-9">
                                <span class="text-xs text-[#9fadbc] w-8">0%</span>
                                <div class="flex-1 h-2 bg-[#A6C5E229] rounded-full overflow-hidden">
                                    <div id="checklist-progress-bar" class="h-full bg-[#579dff] w-0 transition-all duration-300"></div>
                                </div>
                            </div>

                            <div id="checklist-container" class="space-y-2 pl-9"></div>
                            
                            <div class="pl-9 pt-1">
                                <button onclick="showChecklistInput()" id="btn-show-checklist-input" class="bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-3 py-1.5 rounded-[3px] text-sm font-medium transition-colors">Add an item</button>
                                <div id="checklist-input-wrapper" class="hidden flex-col gap-2">
                                    <input id="checklist-input" type="text" class="w-full bg-[#22272b] border border-[#2c333a] rounded-[3px] px-3 py-1.5 text-sm text-[#b6c2cf] focus:bg-[#2c333a] focus:ring-2 focus:ring-[#85b8ff] placeholder-[#9fadbc]" placeholder="Add an item...">
                                    <div class="flex items-center gap-2">
                                        <button id="btn-checklist-add" class="text-sm px-3 py-1.5 bg-[#579dff] hover:bg-[#85b8ff] text-[#1d2125] font-semibold rounded-[3px]">Add</button>
                                        <button onclick="hideChecklistInput()" class="text-[#9fadbc] hover:text-[#b6c2cf] px-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side: activity -->
                <div class="space-y-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm font-semibold text-[#b6c2cf]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Comments and activity
                        </div>
                            <button id="btn-activity-toggle" class="text-xs bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] px-2 py-1.5 rounded-[3px] font-medium transition-colors">Show details</button>
                        </div>
                        
                        <div class="relative">
                            <div id="comment-editor" class="space-y-2 w-full">
                                <div id="comment-toolbar" class="hidden flex items-center gap-2 bg-[#22272b] border border-[#2c333a] rounded-[3px] px-2 py-1 text-xs">
                                    <button id="btn-comment-bold" class="px-2 py-1 rounded hover:bg-[#384148] font-semibold">B</button>
                                    <button id="btn-comment-italic" class="px-2 py-1 rounded hover:bg-[#384148] italic">I</button>
                                    <button id="btn-comment-code" class="px-2 py-1 rounded hover:bg-[#384148]">`</button>
                                    <button id="btn-comment-ul" class="px-2 py-1 rounded hover:bg-[#384148]">•</button>
                                    <button id="btn-comment-link" class="px-2 py-1 rounded hover:bg-[#384148]">🔗</button>
                                    <button id="btn-comment-image" class="px-2 py-1 rounded hover:bg-[#384148]">🖼️</button>
                                </div>
                                <textarea id="comment-input" class="w-full bg-[#22272b] border border-transparent rounded-[3px] px-3 py-2 text-sm text-[#b6c2cf] placeholder-[#9fadbc] focus:bg-[#2c333a] focus:ring-2 focus:ring-[#85b8ff] transition-all min-h-[60px]" placeholder="Write a comment..."></textarea>
                                <div id="comment-actions" class="hidden flex items-center gap-2">
                                    <button id="btn-comment-save" class="px-3 py-1.5 rounded-[3px] bg-[#579dff] text-[#1d2125] hover:bg-[#85b8ff] text-sm font-semibold disabled:opacity-50" disabled>Save</button>
                                    <button id="btn-comment-cancel" class="px-3 py-1.5 rounded-[3px] bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] text-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="comments-container" class="space-y-4 pt-2"></div>
                        <div id="activity-container" class="space-y-4 pt-2 hidden"></div>
                    </div>
                </div>
            </div>
            
            <!-- Hidden footer for logic reference if needed, but visually hidden as per design -->
            <div class="hidden">
                <button id="btn-save-card"></button>
                <button id="btn-cancel-card"></button>
            </div>
        </div>
    </div>
</div>

    <!-- Add to card popup (Frame 4) -->
    <div id="popup-add-to-card" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-transparent" onclick="hideAddToCard()" style="z-index:1;"></div>
        <div class="absolute bg-[#282e33] text-[#b6c2cf] rounded-lg shadow-xl w-72 top-32 left-[calc(50%-9rem)] border border-[#384148] text-sm" style="z-index:2;">
            <div class="flex items-center justify-between px-4 py-2 border-b border-[#384148]">
                <span class="font-semibold text-[#9fadbc]">Add to card</span>
                <button onclick="hideAddToCard()" class="text-[#9fadbc] hover:text-[#b6c2cf]">&times;</button>
            </div>
            <div class="p-2 space-y-1">
                <button onclick="showLabels()" class="w-full text-left px-3 py-2 rounded hover:bg-[#384148] transition-colors flex items-start gap-3 group">
                    <svg class="w-4 h-4 mt-0.5 text-[#9fadbc] group-hover:text-[#b6c2cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <div>
                        <div class="font-medium text-[#b6c2cf]">Labels</div>
                        <div class="text-xs text-[#9fadbc]">Organize, categorize, and prioritize</div>
                    </div>
                </button>
                <button onclick="showDates()" class="w-full text-left px-3 py-2 rounded hover:bg-[#384148] transition-colors flex items-start gap-3 group">
                    <svg class="w-4 h-4 mt-0.5 text-[#9fadbc] group-hover:text-[#b6c2cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <div class="font-medium text-[#b6c2cf]">Dates</div>
                        <div class="text-xs text-[#9fadbc]">Start dates, due dates, and reminders</div>
                    </div>
                </button>
                <button onclick="showChecklist()" class="w-full text-left px-3 py-2 rounded hover:bg-[#384148] transition-colors flex items-start gap-3 group">
                    <svg class="w-4 h-4 mt-0.5 text-[#9fadbc] group-hover:text-[#b6c2cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <div class="font-medium text-[#b6c2cf]">Checklist</div>
                        <div class="text-xs text-[#9fadbc]">Add subtasks</div>
                    </div>
                </button>
                <button onclick="showMembers()" class="w-full text-left px-3 py-2 rounded hover:bg-[#384148] transition-colors flex items-start gap-3 group">
                    <svg class="w-4 h-4 mt-0.5 text-[#9fadbc] group-hover:text-[#b6c2cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <div>
                        <div class="font-medium text-[#b6c2cf]">Members</div>
                        <div class="text-xs text-[#9fadbc]">Assign members</div>
                    </div>
                </button>
                <button onclick="showAttach()" class="w-full text-left px-3 py-2 rounded hover:bg-[#384148] transition-colors flex items-start gap-3 group">
                    <svg class="w-4 h-4 mt-0.5 text-[#9fadbc] group-hover:text-[#b6c2cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    <div>
                        <div class="font-medium text-[#b6c2cf]">Attachment</div>
                        <div class="text-xs text-[#9fadbc]">Add links, pages, work items, and more</div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Labels popup (Frame 7) -->
    <div id="popup-labels" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-black/40" onclick="hideLabels()" style="z-index:1;"></div>
        <div class="absolute bg-[#1e1e1e] text-[#b6c2cf] rounded-lg shadow-xl w-64 top-40 left-1/2 -translate-x-1/2 border border-[#2c333a] text-xs" style="z-index:2;">
            <div class="flex items-center justify-between px-3 py-2 border-b border-[#2c333a]">
                <span>Labels</span>
                <button onclick="hideLabels()" class="text-lg leading-none hover:text-white">&times;</button>
            </div>
            <div class="p-3 space-y-2">
                <input type="text" placeholder="Search labels..." class="w-full bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 mb-2 text-[#b6c2cf] focus:outline-none focus:ring-1 focus:ring-[#85b8ff]">
                <div id="labels-list" class="space-y-1">
                    <!-- label rows injected -->
                </div>
            </div>
        </div>
    </div>

    <!-- Attach popup (Frame 6) -->
    <div id="popup-attach" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-transparent" onclick="hideAttach()" style="z-index:1;"></div>
        <div class="absolute bg-[#282e33] text-[#b6c2cf] rounded-lg shadow-xl w-80 top-44 left-[calc(50%-10rem)] border border-[#384148] text-sm" style="z-index:2;">
            <div class="flex items-center justify-between px-4 py-2 border-b border-[#384148]">
                <span class="font-semibold text-[#9fadbc] mx-auto">Attach</span>
                <button onclick="hideAttach()" class="text-[#9fadbc] hover:text-[#b6c2cf] absolute right-4">&times;</button>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <div class="text-xs font-bold text-[#9fadbc] mb-2">Attach a file from your computer</div>
                    <div class="text-xs text-[#9fadbc] mb-2">You can also drag and drop files to upload them.</div>
                    <input id="attach-file-input" type="file" class="hidden" accept="image/*,.png,.jpg,.jpeg,.gif,.webp,.bmp">
                    <button id="btn-attach-popup-choose" class="w-full bg-[#2c333a] hover:bg-[#384148] px-3 py-2 rounded transition-colors text-[#b6c2cf] font-medium border border-[#384148]">Choose a file</button>
                </div>
                
                <div class="space-y-2">
                    <div class="text-xs font-bold text-[#9fadbc]">Search or paste a link <span class="text-red-500">*</span></div>
                    <input id="attach-link-input" type="text" placeholder="Find recent links or paste a new link" class="w-full bg-[#22272b] border border-[#2c333a] rounded px-3 py-2 text-[#b6c2cf] focus:outline-none focus:border-[#85b8ff] text-sm">
                </div>

                <div class="space-y-2">
                    <div class="text-xs font-bold text-[#9fadbc]">Display text (optional)</div>
                    <input id="attach-display-input" type="text" placeholder="Text to display" class="w-full bg-[#22272b] border border-[#2c333a] rounded px-3 py-2 text-[#b6c2cf] focus:outline-none focus:border-[#85b8ff] text-sm">
                    <div class="text-[10px] text-[#9fadbc]">Give this link a title or description</div>
                </div>

                <div class="space-y-2">
                     <div class="text-xs font-bold text-[#9fadbc]">Recently Viewed</div>
                     <div class="space-y-2">
                         <div class="flex items-start gap-2 cursor-pointer hover:bg-[#384148] p-1 rounded">
                             <span class="mt-0.5 text-[#579dff]"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12z"/></svg></span>
                             <div>
                                 <div class="text-xs font-medium text-[#b6c2cf]">selesaikan fitur anjing</div>
                                 <div class="text-[10px] text-[#9fadbc]">My Trello board • Viewed 4 minutes ago</div>
                             </div>
                         </div>
                         <div class="flex items-start gap-2 cursor-pointer hover:bg-[#384148] p-1 rounded">
                             <span class="mt-0.5 text-[#579dff]"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12z"/></svg></span>
                             <div>
                                 <div class="text-xs font-medium text-[#b6c2cf]">SS</div>
                                 <div class="text-[10px] text-[#9fadbc]">My Trello board • Viewed 35 minutes ago</div>
                             </div>
                         </div>
                         <div class="flex items-start gap-2 cursor-pointer hover:bg-[#384148] p-1 rounded">
                             <span class="mt-0.5 text-[#579dff]"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12z"/></svg></span>
                             <div>
                                 <div class="text-xs font-medium text-[#b6c2cf]">ZZ</div>
                                 <div class="text-[10px] text-[#9fadbc]">My Trello board • Viewed 8 hours ago</div>
                             </div>
                         </div>
                     </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button onclick="hideAttach()" class="px-4 py-1.5 rounded hover:bg-[#384148] text-[#b6c2cf] transition-colors">Cancel</button>
                    <button id="btn-attach-insert" class="px-4 py-1.5 rounded bg-[#579dff] text-[#1d2125] hover:bg-[#85b8ff] font-semibold transition-colors">Insert</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dates popup (Frame 9) -->
    <div id="popup-dates" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-transparent" onclick="hideDates()" style="z-index:1;"></div>
        <div class="absolute bg-[#282e33] text-[#b6c2cf] rounded-lg shadow-xl w-[300px] top-40 left-[calc(50%-150px)] border border-[#384148] text-sm" style="z-index:2;">
            <div class="flex items-center justify-between px-4 py-2 border-b border-[#384148]">
                <span class="font-semibold text-[#9fadbc] mx-auto">Dates</span>
                <button onclick="hideDates()" class="text-[#9fadbc] hover:text-[#b6c2cf] absolute right-4">&times;</button>
            </div>
            <div class="p-4 space-y-4">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between text-[#b6c2cf] mb-2">
                    <div class="flex gap-2">
                        <button id="cal-prev-year" class="hover:text-white">&laquo;</button>
                        <button id="cal-prev" class="hover:text-white">&lsaquo;</button>
                    </div>
                    <span id="cal-label" class="font-bold">January 2026</span>
                    <div class="flex gap-2">
                        <button id="cal-next" class="hover:text-white">&rsaquo;</button>
                        <button id="cal-next-year" class="hover:text-white">&raquo;</button>
                    </div>
                </div>
                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 text-center text-xs gap-y-2 mb-2">
                    <span class="font-bold text-[#9fadbc]">Mon</span>
                    <span class="font-bold text-[#9fadbc]">Tue</span>
                    <span class="font-bold text-[#9fadbc]">Wed</span>
                    <span class="font-bold text-[#9fadbc]">Thu</span>
                    <span class="font-bold text-[#9fadbc]">Fri</span>
                    <span class="font-bold text-[#9fadbc]">Sat</span>
                    <span class="font-bold text-[#9fadbc]">Sun</span>
                </div>
                <div id="cal-days" class="grid grid-cols-7 text-center text-xs gap-y-1 mb-4"></div>

                <div class="space-y-2">
                    <div class="text-xs font-bold text-[#9fadbc]">Start date</div>
                    <div class="flex items-center gap-2">
                        <input id="start-date-toggle" type="checkbox" class="rounded bg-[#22272b] border-[#2c333a] text-[#579dff] focus:ring-0">
                        <input id="start-date-input" type="text" readonly class="bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] w-36 focus:outline-none focus:border-[#85b8ff]">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-xs font-bold text-[#9fadbc]">Due date</div>
                    <div class="flex items-center gap-2">
                        <input id="due-date-toggle" type="checkbox" checked class="rounded bg-[#22272b] border-[#2c333a] text-[#579dff] focus:ring-0">
                        <input id="due-date-input" type="text" readonly class="bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] w-36 focus:outline-none focus:border-[#85b8ff]">
                        <input id="due-time-input" type="time" class="bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] w-24 focus:outline-none focus:border-[#85b8ff]">
                    </div>
                </div>
                
                <div class="space-y-1">
                     <div class="text-xs font-bold text-[#9fadbc]">Recurring <span class="bg-[#a6c5e229] text-[#9f8fef] px-1 rounded text-[10px] ml-1">NEW</span></div>
                     <select class="w-full bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] focus:outline-none focus:border-[#85b8ff] text-xs">
                        <option>Never</option>
                     </select>
                </div>

                <div class="space-y-1">
                     <div class="text-xs font-bold text-[#9fadbc]">Set due date reminder</div>
                     <select class="w-full bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] focus:outline-none focus:border-[#85b8ff] text-xs">
                        <option>None</option>
                        <option>1 day before</option>
                     </select>
                     <div class="text-[10px] text-[#9fadbc] mt-1">Reminders will be sent to all members and watchers of this card.</div>
                </div>

                <div class="flex flex-col gap-2 pt-2">
                    <button id="btn-date-save" class="w-full py-1.5 rounded bg-[#579dff] text-[#1d2125] hover:bg-[#85b8ff] font-semibold transition-colors">Save</button>
                    <button id="btn-date-remove" class="w-full py-1.5 rounded bg-[#2c333a] hover:bg-[#384148] text-[#b6c2cf] transition-colors">Remove</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Members popup (New) -->
    <div id="popup-members" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-transparent" onclick="hideMembers()" style="z-index:1;"></div>
        <div class="absolute bg-[#282e33] text-[#b6c2cf] rounded-lg shadow-xl w-72 top-40 left-[calc(50%-9rem)] border border-[#384148] text-sm" style="z-index:2;">
            <div class="flex items-center justify-between px-4 py-2 border-b border-[#384148]">
                <span class="font-semibold text-[#9fadbc] mx-auto">Members</span>
                <button onclick="hideMembers()" class="text-[#9fadbc] hover:text-[#b6c2cf] absolute right-4">&times;</button>
            </div>
            <div class="p-3 space-y-3">
                <input type="text" placeholder="Search members" class="w-full bg-[#22272b] border border-[#579dff] rounded px-3 py-1.5 text-[#b6c2cf] focus:outline-none text-sm">
                
                <div>
                    <div class="text-xs font-bold text-[#9fadbc] mb-2">Card members</div>
                    <div id="btn-add-member-current" class="flex items-center justify-between hover:bg-[#384148] p-1 rounded cursor-pointer group">
                        <div class="flex items-center gap-2">
                            <div id="current-member-initials" class="w-8 h-8 rounded-full bg-[#705dfe] flex items-center justify-center text-xs font-bold text-white uppercase">U</div>
                            <span id="current-member-name" class="text-[#b6c2cf]">User</span>
                        </div>
                        <button class="text-[#9fadbc] hover:text-[#b6c2cf]">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checklist popup (Frame 10) -->
    <div id="popup-checklist" class="fixed inset-0 hidden z-50">
        <div class="absolute inset-0 bg-black/40" onclick="hideChecklist()" style="z-index:1;"></div>
        <div class="absolute bg-[#1e1e1e] text-[#b6c2cf] rounded-lg shadow-xl w-72 top-44 left-1/2 -translate-x-1/2 border border-[#2c333a] text-xs" style="z-index:2;">
            <div class="flex items-center justify-between px-3 py-2 border-b border-[#2c333a]">
                <span>Add Checklist</span>
                <button onclick="hideChecklist()" class="text-lg leading-none hover:text-white">&times;</button>
            </div>
            <div class="p-3 space-y-3">
                <input id="checklist-popup-input" type="text" placeholder="Checklist" class="w-full bg-[#22272b] border border-[#2c333a] rounded px-2 py-1 text-[#b6c2cf] focus:outline-none focus:ring-1 focus:ring-[#85b8ff]">
                <button id="btn-checklist-popup-add" class="w-full bg-[#579dff] hover:bg-[#85b8ff] text-[#1d2125] font-semibold px-3 py-1 rounded transition-colors">Add</button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('card-modal');
        const btnAddToday = document.getElementById('btn-add-today');
        const btnAddWeekly = document.getElementById('btn-add-weekly');
        const btnAddLater = document.getElementById('btn-add-later');
        const btnSaveCard = document.getElementById('btn-save-card');
        const btnCancelCard = document.getElementById('btn-cancel-card');
        const btnCloseModal = document.getElementById('card-modal-close');
        const todayContainer = document.getElementById('today-cards');
        const weekContainer = document.getElementById('week-cards');
        const laterContainer = document.getElementById('later-cards');
        const titleInput = document.getElementById('card-title');
        const descInput = document.getElementById('card-description');
        const listSelect = document.getElementById('list-select');
        const dateInput = document.getElementById('due-date-input');
        const dueTimeInput = document.getElementById('due-time-input');
        const startDateInput = document.getElementById('start-date-input');
        const startDateToggle = document.getElementById('start-date-toggle');
        const dueDateToggle = document.getElementById('due-date-toggle');
        const calDays = document.getElementById('cal-days');
        const calLabel = document.getElementById('cal-label');
        const calPrev = document.getElementById('cal-prev');
        const calNext = document.getElementById('cal-next');
        const calPrevYear = document.getElementById('cal-prev-year');
        const calNextYear = document.getElementById('cal-next-year');
        let calYear = new Date().getFullYear();
        let calMonth = new Date().getMonth(); // 0-11
        let calendarTarget = 'due';
        startDateToggle?.addEventListener('change', () => { calendarTarget = 'start'; });
        dueDateToggle?.addEventListener('change', () => { calendarTarget = 'due'; });
        const btnDateSave = document.getElementById('btn-date-save');
        const btnDateRemove = document.getElementById('btn-date-remove');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const labelsListEl = document.getElementById('labels-list');
        const checklistContainer = document.getElementById('checklist-container');
        const checklistInput = document.getElementById('checklist-input');
        const btnChecklistAdd = document.getElementById('btn-checklist-add');
        const attachList = document.getElementById('attach-list');
        const attachName = document.getElementById('attach-name');
        const attachUrl = document.getElementById('attach-url');
        const btnAttachAdd = document.getElementById('btn-attach-add');
        const descToolbar = document.getElementById('desc-toolbar');
        const commentToolbar = document.getElementById('comment-toolbar');
        const commentInput = document.getElementById('comment-input');
        const descActions = document.getElementById('desc-actions');
        const btnDescSave = document.getElementById('btn-desc-save');
        const btnDescCancel = document.getElementById('btn-desc-cancel');
        const btnDescEdit = document.getElementById('btn-desc-edit');
        const commentActions = document.getElementById('comment-actions');
        const btnCommentSave = document.getElementById('btn-comment-save');
        const btnCommentCancel = document.getElementById('btn-comment-cancel');
        const commentsContainer = document.getElementById('comments-container');
        let originalDesc = '';

        let currentList = 'today';
        let currentCard = null;
        let currentDueDate = null; // ISO date string
        let currentStartDate = null; // ISO date string (UI only)
        let selectedLabels = [];
        let selectedMembers = [];
        let checklistItems = [];
        let attachments = [];
        let activities = []; // stores both comments and system activities
        let currentCompleted = false;
        const CURRENT_USER = { id: {{ Auth::id() }}, name: '{{ addslashes(Auth::user()->name) }}' };
        const CURRENT_INITIALS = (CURRENT_USER.name || '').split(/\s+/).map(s => s[0]).slice(0,2).join('').toUpperCase();
        let currentInlineAddEl = null;
        function getAssignedAuthor() {
            const m = selectedMembers[0];
            if (m && m.name) {
                return { name: m.name, initials: m.initials || (m.name || '').split(/\s+/).map(s => s[0]).slice(0,2).join('').toUpperCase() };
            }
            return { name: CURRENT_USER.name, initials: CURRENT_INITIALS };
        }
        const activityContainer = document.getElementById('activity-container');
        const activityToggleBtn = document.getElementById('btn-activity-toggle');
        
        let commentToDeleteId = null;

        function renderActivities() {
            if (commentsContainer) commentsContainer.innerHTML = '';
            if (activityContainer) activityContainer.innerHTML = '';
            
            activities.forEach(act => {
                if (!act.id) act.id = 'temp_' + Math.random().toString(36).substr(2, 9);

                const el = document.createElement('div');
                el.className = 'text-sm text-[#b6c2cf] flex items-start gap-2 w-full';
                const time = act.timestamp ? new Date(act.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
                const author = act.author || { name: 'Unknown', initials: '?' };
                
                if (act.type === 'comment') {
                    const isAuthor = author.name === CURRENT_USER.name;
                    const readViewId = `comment-read-${act.id}`;
                    const editViewId = `comment-edit-${act.id}`;
                    const inputId = `comment-input-${act.id}`;

                    el.innerHTML = `
                        <div class="w-6 h-6 rounded-full bg-[#705dfe] border-2 border-[#22272b] flex items-center justify-center text-[10px] font-bold text-white uppercase flex-shrink-0">${author.initials}</div>
                        <div class="flex-1 min-w-0 group">
                            <!-- Read View -->
                            <div id="${readViewId}" class="block">
                                <div class="bg-[#22272b] rounded-[3px] px-3 py-2 mb-1 text-[#b6c2cf] break-words whitespace-pre-wrap">${act.text}</div>
                                <div class="text-[11px] text-[#9fadbc] flex items-center gap-2">
                                    <span class="font-semibold">${author.name}</span>
                                    <span>${time}</span>
                                    ${isAuthor ? `
                                        <span class="mx-1">•</span>
                                        <button onclick="editComment('${act.id}')" class="hover:underline hover:text-[#b6c2cf]">Edit</button>
                                        <span class="mx-1">•</span>
                                        <button onclick="confirmDeleteComment('${act.id}', this)" class="hover:underline hover:text-[#b6c2cf]">Delete</button>
                                    ` : ''}
                                </div>
                            </div>
                            
                            <!-- Edit View -->
                            <div id="${editViewId}" class="hidden">
                                <div class="bg-[#22272b] border border-[#738496] rounded-[3px] overflow-hidden mb-2 transition-shadow focus-within:ring-2 focus-within:ring-[#85b8ff]">
                                    <div class="flex items-center gap-3 px-2 py-1 border-b border-[#3b444c] text-[#9fadbc] bg-[#22272b]">
                                       <i class="fa-solid fa-font text-xs cursor-pointer hover:text-[#b6c2cf]"></i>
                                       <i class="fa-solid fa-bold text-xs cursor-pointer hover:text-[#b6c2cf]"></i>
                                       <i class="fa-solid fa-italic text-xs cursor-pointer hover:text-[#b6c2cf]"></i>
                                       <i class="fa-solid fa-list-ul text-xs cursor-pointer hover:text-[#b6c2cf]"></i>
                                    </div>
                                    <textarea id="${inputId}" class="w-full bg-[#22272b] text-[#b6c2cf] p-2 text-sm focus:outline-none resize-y min-h-[80px] block" placeholder="Write a comment...">${act.text}</textarea>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick="saveComment('${act.id}')" class="bg-[#579dff] text-[#1d2125] hover:bg-[#85b8ff] font-semibold text-sm px-3 py-1.5 rounded-[3px]">Save</button>
                                    <button onclick="cancelEdit('${act.id}')" class="text-[#9fadbc] hover:text-[#b6c2cf] text-sm px-3 py-1.5">Discard changes</button>
                                </div>
                            </div>
                        </div>
                    `;
                    commentsContainer?.appendChild(el);
                } else {
                    el.innerHTML = `<div class="w-6 h-6 rounded-full bg-[#705dfe] border-2 border-[#22272b] flex items-center justify-center text-[10px] font-bold text-white uppercase flex-shrink-0">${author.initials}</div><div class="flex-1"><div class="text-[11px] text-[#9fadbc]"><span class="font-semibold">${author.name}</span> ${act.text}</div><div class="text-[11px] text-[#9fadbc]">${time}</div></div>`;
                    activityContainer?.appendChild(el);
                }
            });
        }

        function addActivity(text, important = false) {
            const author = getAssignedAuthor();
            const timestamp = new Date().toISOString();
            const type = important ? 'comment' : 'system';
            const id = 'act_' + Date.now() + Math.random().toString(36).substr(2, 9);
            
            const newActivity = {
                id,
                text,
                type,
                author,
                timestamp
            };
            
            // Add to start of array since we want newest first, but rendering appends. 
            // Wait, standard is newest at top. So we should prepend to container, but unshift to array.
            activities.unshift(newActivity);
            
            renderActivities(); // Re-render to show edit/delete buttons correctly
            scheduleAutoSave();
        }

        // Global functions for inline edit/delete
        window.editComment = function(id) {
            document.getElementById(`comment-read-${id}`)?.classList.add('hidden');
            document.getElementById(`comment-edit-${id}`)?.classList.remove('hidden');
            const ta = document.getElementById(`comment-input-${id}`);
            if (ta) {
                ta.focus();
                ta.setSelectionRange(ta.value.length, ta.value.length);
            }
        };

        window.cancelEdit = function(id) {
            document.getElementById(`comment-read-${id}`)?.classList.remove('hidden');
            document.getElementById(`comment-edit-${id}`)?.classList.add('hidden');
            const act = activities.find(a => a.id === id);
            const ta = document.getElementById(`comment-input-${id}`);
            if (act && ta) ta.value = act.text;
        };

        window.saveComment = function(id) {
            const ta = document.getElementById(`comment-input-${id}`);
            if (!ta) return;
            const newText = ta.value.trim();
            if (!newText) return;

            const act = activities.find(a => a.id === id);
            if (act) {
                act.text = newText;
                renderActivities();
                scheduleAutoSave();
            }
        };

        window.confirmDeleteComment = function(id, btnElement) {
            commentToDeleteId = id;
            const popover = document.getElementById('delete-confirm-popover');
            if (!popover) return;
            
            const rect = btnElement.getBoundingClientRect();
            const left = Math.min(rect.left, window.innerWidth - 300);
            
            popover.style.top = (rect.bottom + 5) + 'px';
            popover.style.left = left + 'px';
            popover.classList.remove('hidden');
        };

        window.hideDeletePopover = function() {
            const popover = document.getElementById('delete-confirm-popover');
            if (popover) popover.classList.add('hidden');
            commentToDeleteId = null;
        };

        window.performDelete = function() {
            if (!commentToDeleteId) return;
            activities = activities.filter(a => a.id !== commentToDeleteId);
            renderActivities();
            scheduleAutoSave();
            hideDeletePopover();
        };

        document.addEventListener('click', (e) => {
            const popover = document.getElementById('delete-confirm-popover');
            if (popover && !popover.classList.contains('hidden')) {
                if (!popover.contains(e.target) && !e.target.closest('button[onclick^="confirmDeleteComment"]')) {
                    hideDeletePopover();
                }
            }
        });
        activityToggleBtn?.addEventListener('click', () => {
            if (!activityContainer) return;
            const shown = !activityContainer.classList.contains('hidden');
            if (shown) {
                activityContainer.classList.add('hidden');
                activityToggleBtn.textContent = 'Show details';
            } else {
                activityContainer.classList.remove('hidden');
                activityToggleBtn.textContent = 'Hide details';
            }
        });

        const LABEL_OPTIONS = [
            { key: 'green', name: 'Done', class: 'bg-green-600' },
            { key: 'yellow', name: 'In Progress', class: 'bg-yellow-500' },
            { key: 'orange', name: 'Next', class: 'bg-orange-500' },
            { key: 'red', name: 'Blocked', class: 'bg-red-500' },
            { key: 'purple', name: 'Review', class: 'bg-purple-600' },
            { key: 'blue', name: 'Info', class: 'bg-blue-600' },
        ];

        function resetFormState() {
            checklistItems = [];
            attachments = [];
            activities = [];
            selectedLabels = [];
            selectedMembers = [];
            currentDueDate = null;
            currentCompleted = false;
            if (commentsContainer) commentsContainer.innerHTML = '';
            if (activityContainer) {
                activityContainer.innerHTML = '';
                activityContainer.classList.add('hidden');
            }
            if (activityToggleBtn) activityToggleBtn.textContent = 'Show details';
            renderLabelOptions();
            renderSelectedLabels();
            renderChecklist();
            renderAttachments();
            renderMembers();
            renderActivities();
            renderCompleteModal();
            descToolbar && descToolbar.classList.add('hidden');
            descActions && descActions.classList.add('hidden');
            originalDesc = '';
        }

        // open modal for creating new card in given list
        function openModal(listKey = 'today') {
            currentCard = null;
            currentList = listKey;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            titleInput.value = 'Bikin Figma';
            descInput.value = '';
            listSelect.value = currentList;
            resetFormState();
            syncDateInput();
            renderCompleteModal();
            titleInput.focus();
            btnDescEdit?.addEventListener('click', () => {
                originalDesc = descInput.value || '';
                descToolbar && descToolbar.classList.remove('hidden');
                descActions && descActions.classList.remove('hidden');
                descInput.focus();
            });
            btnDescSave?.addEventListener('click', () => {
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
                scheduleAutoSave();
            });
            btnDescCancel?.addEventListener('click', () => {
                descInput.value = originalDesc || '';
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
            });
            descInput?.addEventListener('focus', () => {
                descToolbar && descToolbar.classList.remove('hidden');
                descActions && descActions.classList.remove('hidden');
            });
            descInput?.addEventListener('blur', () => {
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
            });
        }

        // open modal for existing card (edit/view)
        function openModalFromCard(cardData) {
            currentCard = { ...cardData };
            currentList = cardData.list_key || 'today';
            currentDueDate = cardData.due_date || null;
            currentStartDate = cardData.start_date || null;
            currentCompleted = !!cardData.completed;
            selectedLabels = Array.isArray(cardData.labels) ? [...cardData.labels] : [];
            selectedMembers = Array.isArray(cardData.members) ? [...cardData.members] : [];
            checklistItems = Array.isArray(cardData.checklist) ? [...cardData.checklist] : [];
            attachments = Array.isArray(cardData.attachments) ? [...cardData.attachments] : [];
            activities = Array.isArray(cardData.activities) ? [...cardData.activities] : [];

            if (commentsContainer) commentsContainer.innerHTML = '';
            if (activityContainer) {
                activityContainer.innerHTML = '';
                activityContainer.classList.add('hidden');
            }
            if (activityToggleBtn) activityToggleBtn.textContent = 'Show details';

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            titleInput.value = cardData.title || '';
            descInput.value = cardData.description || '';
            listSelect.value = currentList;

            renderLabelOptions();
            renderSelectedLabels();
            renderChecklist();
            renderAttachments();
            renderMembers();
            renderActivities();
            syncDateInput();
            renderCompleteModal();
            titleInput.focus();
            if (!autosaveBound) {
                autosaveBound = true;
                titleInput?.addEventListener('input', () => scheduleAutoSave());
                descInput?.addEventListener('input', () => scheduleAutoSave());
            }
            descInput?.addEventListener('focus', () => {
                descToolbar && descToolbar.classList.remove('hidden');
                descActions && descActions.classList.remove('hidden');
            });
            descInput?.addEventListener('blur', () => {
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
            });
            btnDescEdit?.addEventListener('click', () => {
                originalDesc = descInput.value || '';
                descToolbar && descToolbar.classList.remove('hidden');
                descActions && descActions.classList.remove('hidden');
                descInput.focus();
            });
            btnDescSave?.addEventListener('click', () => {
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
                scheduleAutoSave();
            });
            btnDescCancel?.addEventListener('click', () => {
                descInput.value = originalDesc || '';
                descToolbar && descToolbar.classList.add('hidden');
                descActions && descActions.classList.add('hidden');
            });
        }
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function startInlineAdd(listKey) {
            if (currentInlineAddEl) {
                currentInlineAddEl.remove();
                currentInlineAddEl = null;
            }
            const container = listKey === 'weekly' ? weekContainer : listKey === 'later' ? laterContainer : todayContainer;
            const el = document.createElement('div');
            el.className = 'bg-transparent mb-2';
            el.innerHTML = `
                <div class="rounded-lg border border-[#384148] bg-[#22272b] p-2">
                    <input id="inline-title" type="text" class="w-full bg-[#22272b] border border-[#2c333a] rounded px-3 py-2 text-sm text-[#b6c2cf] placeholder-[#9fadbc] focus:bg-[#2c333a] focus:ring-2 focus:ring-[#85b8ff]" placeholder="Enter a title or paste a link">
                    <div class="flex items-center gap-2 mt-2">
                        <button data-action="add" class="bg-[#579dff] hover:bg-[#85b8ff] text-[#1d2125] px-3 py-1.5 rounded text-sm font-semibold">Add card</button>
                        <button data-action="cancel" class="text-[#9fadbc] hover:text-[#b6c2cf] px-2 py-1 text-sm">×</button>
                    </div>
                </div>
            `;
            container.prepend(el);
            currentInlineAddEl = el;
            const input = el.querySelector('#inline-title');
            const addBtn = el.querySelector('[data-action="add"]');
            const cancelBtn = el.querySelector('[data-action="cancel"]');
            function submit() {
                const title = (input.value || '').trim();
                if (!title) {
                    input.focus();
                    return;
                }
                const payload = {
                    title,
                    description: null,
                    list_key: listKey,
                    due_date: null,
                    start_date: null,
                    completed: false,
                    labels: [],
                    members: [],
                    checklist: [],
                    attachments: [],
                    activities: [],
                };
                fetch('{{ route('developer.cards.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                }).then(async (res) => {
                    if (!res.ok) {
                        const err = await res.json().catch(() => ({}));
                        throw new Error(err.message || 'Failed to save card');
                    }
                    return res.json();
                }).then(() => {
                    el.remove();
                    currentInlineAddEl = null;
                    loadCards();
                }).catch(e => {
                    alert('Gagal menyimpan kartu: ' + e.message);
                });
            }
            addBtn.onclick = submit;
            cancelBtn.onclick = () => {
                el.remove();
                currentInlineAddEl = null;
            };
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') submit();
                if (e.key === 'Escape') cancelBtn.click();
            });
            input.focus();
        }
        btnAddToday.addEventListener('click', () => startInlineAdd('today'));
        btnAddWeekly.addEventListener('click', () => startInlineAdd('weekly'));
        btnAddLater.addEventListener('click', () => startInlineAdd('later'));

        // if user changes select manually, update target list
        listSelect.addEventListener('change', (e) => {
            currentList = e.target.value || 'today';
        });

        function formatDateLabel(iso) {
            if (!iso) return null;
            const d = new Date(iso);
            if (isNaN(d)) return null;
            const formatter = new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric' });
            const time = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            return `${formatter.format(d).toUpperCase()} • ${time}`;
        }
        function isImageUrl(u) {
            const s = String(u || '').toLowerCase();
            if (!s) return false;
            if (s.startsWith('blob:') || s.startsWith('data:image')) return true;
            try {
                const parsed = new URL(s, window.location.origin);
                const path = parsed.pathname.toLowerCase();
                if (/\.(png|jpg|jpeg|gif|bmp|webp)$/.test(path)) return true;
                return false;
            } catch {
                return /\.(png|jpg|jpeg|gif|bmp|webp)(\?.*)?$/.test(s);
            }
        }

        function renderLabels(labels = []) {
            if (!labels.length) return '';
            return `<div class="flex gap-1 mb-1">` + labels.map(l => {
                const found = LABEL_OPTIONS.find(o => o.key === l);
                const cls = found ? found.class : 'bg-gray-400';
                return `<span class="inline-block w-10 h-1.5 rounded ${cls}"></span>`;
            }).join('') + `</div>`;
        }

        function createCardElement(cardData) {
            // Ensure array properties are arrays (handle null from DB)
            const checklist = Array.isArray(cardData.checklist) ? cardData.checklist : [];
            const attachments = Array.isArray(cardData.attachments) ? cardData.attachments : [];
            const labels = Array.isArray(cardData.labels) ? cardData.labels : [];
            const members = Array.isArray(cardData.members) ? cardData.members : [];
            
            const { title, list_key, due_date, completed = false } = cardData;
            const cardEl = document.createElement('div');

            // Checklist calculations
            const clTotal = checklist.length;
            const clDone = checklist.filter(i => i.done).length;
            const hasChecklist = clTotal > 0;
            const isChecklistDone = hasChecklist && clDone === clTotal;
            
            const attCount = attachments.length;

            // Dark theme base
            let baseClasses = 'bg-[#22272b] text-[#b6c2cf] border-[#384148] hover:border-[#85b8ff]';
            
            // Minimal color hint based on list_key if desired, or just stick to unified dark theme
            // Image 3 and 4 show consistent dark style.
            
            cardEl.className = `${baseClasses} rounded-lg shadow-sm border p-0 cursor-pointer group relative overflow-hidden mb-2`;
            
            // Cover
            let coverHtml = '';
            if (attachments.length > 0) {
                const first = attachments[0];
                coverHtml = `
                    <div class="w-full h-28 bg-[#1d2125] relative overflow-hidden">
                        <img src="${first.url}" alt="${first.name}" class="w-full h-28 object-cover" onerror="this.style.display='none'">
                    </div>
                `;
            }
            // Labels
            const labelsHtml = labels.length ? `<div class="flex flex-wrap gap-1 mb-1.5 px-3 pt-3">${labels.map(l => {
                const found = LABEL_OPTIONS.find(o => o.key === l);
                const cls = found ? found.class : 'bg-gray-400';
                return `<span class="h-1.5 w-10 rounded-full ${cls}"></span>`;
            }).join('')}</div>` : '<div class="pt-3"></div>';

            // Title with complete toggle
            const toggleHtml = `<button aria-label="complete-toggle" title="${completed ? 'Mark incomplete' : 'Mark complete'}" class="${completed ? 'inline-flex items-center justify-center w-4 h-4 rounded-full bg-[#4bce97] text-[#1d2125]' : 'inline-flex items-center justify-center w-4 h-4 rounded-full border border-[#9fadbc] text-[#9fadbc]'}">${completed ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' : ''}</button>`;
            const titleHtml = `<div class="px-3 mb-2 text-sm font-semibold text-[#b6c2cf] flex items-center gap-2">${toggleHtml}<span class="truncate">${title}</span></div>`;

            // Footer
            let footerHtml = '<div class="px-3 pb-3 flex items-center flex-wrap gap-3 text-[#9fadbc]">';
            
            // Date
            if (due_date) {
                 const d = new Date(due_date);
                 const isDueSoon = true; 
                 const dateClass = completed ? 'bg-[#4bce97] text-[#1d2125]' : (isDueSoon ? 'bg-[#e2b203] text-[#1d2125]' : 'text-[#9fadbc]');
                 const iconColor = 'text-[#1d2125]';
                 
                 footerHtml += `
                    <div class="flex items-center gap-1.5 px-1.5 py-0.5 rounded-[3px] text-xs font-medium ${dateClass}">
                        <svg class="w-3.5 h-3.5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${d.toLocaleDateString('en-US', {day:'numeric', month:'short'})}</span>
                    </div>
                 `;
            }

            // Attachments
            if (attCount > 0) {
                footerHtml += `
                    <div class="flex items-center gap-1 text-xs hover:text-[#b6c2cf]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <span>${attCount}</span>
                    </div>
                `;
            }

            // Checklist
            if (hasChecklist) {
                 const checkClass = isChecklistDone ? 'bg-[#4bce97] text-[#1d2125] px-1.5 py-0.5 rounded-[3px]' : 'hover:text-[#b6c2cf]';
                 const checkIconColor = isChecklistDone ? 'text-[#1d2125]' : 'currentColor';
                 footerHtml += `
                    <div class="flex items-center gap-1 text-xs ${checkClass}">
                        <svg class="w-3.5 h-3.5 ${checkIconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${clDone}/${clTotal}</span>
                    </div>
                 `;
            }

            // Spacer
            footerHtml += '<div class="flex-1"></div>';

            // Members
            if (members.length > 0) {
                 footerHtml += `<div class="flex -space-x-1.5">`;
                 members.forEach(m => {
                     footerHtml += `<div class="w-6 h-6 rounded-full bg-[#705dfe] border-2 border-[#22272b] flex items-center justify-center text-[9px] font-bold text-white uppercase shadow-sm" title="${m.name}">${m.initials || 'Y'}</div>`;
                 });
                 footerHtml += `</div>`;
            }

            footerHtml += '</div>';

            cardEl.innerHTML = coverHtml + labelsHtml + titleHtml + footerHtml;
            return cardEl;
        }

        btnSaveCard.addEventListener('click', async () => {
            const title = titleInput.value.trim() || 'Untitled';
            const listKey = currentList || 'today';
            const description = descInput.value.trim() || null;
            const dueDate = currentDueDate;
            const checklist = checklistItems;
            const attachPayload = attachments;
            const activitiesPayload = activities;

            try {
                const payload = {
                    title: title,
                    description: description,
                    list_key: listKey,
                    due_date: dueDate,
                    completed: currentCompleted,
                    labels: selectedLabels,
                    members: selectedMembers,
                    checklist: checklist,
                    attachments: attachPayload,
                    activities: activitiesPayload,
                };

                let url, method;
                if (currentCard && currentCard.id) {
                    url = `{{ url('/developer/board/cards') }}/${currentCard.id}`;
                    method = 'PATCH';
                } else {
                    url = '{{ route('developer.cards.store') }}';
                    method = 'POST';
                }

                const response = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Failed to save card');
                }
                await response.json();
                closeModal();
                await loadCards();
            } catch (err) {
                alert('Gagal menyimpan kartu: ' + err.message);
            }
        });
        btnCancelCard.addEventListener('click', closeModal);
        btnCloseModal.addEventListener('click', closeModal);

        // Labels popup
        const popupLabels = document.getElementById('popup-labels');
        function showLabels() {
            popupLabels.classList.remove('hidden');
            hideAddToCard();
        }
        function hideLabels() {
            popupLabels.classList.add('hidden');
        }

        // Dates popup
        const popupDates = document.getElementById('popup-dates');
        function showDates() {
            syncDateInput();
            {
                const base = currentDueDate ? new Date(currentDueDate) : (currentStartDate ? new Date(currentStartDate) : new Date());
                if (!isNaN(base)) {
                    calYear = base.getFullYear();
                    calMonth = base.getMonth();
                }
            }
            renderCalendar();
            popupDates.classList.remove('hidden');
            hideAddToCard();
        }
        function hideDates() {
            popupDates.classList.add('hidden');
        }

        // Checklist popup
        const popupChecklist = document.getElementById('popup-checklist');
        function showChecklist() {
            popupChecklist.classList.remove('hidden');
            hideAddToCard();
        }
        function hideChecklist() {
            popupChecklist.classList.add('hidden');
        }

        // Members popup
        const popupMembers = document.getElementById('popup-members');
        function showMembers() {
            popupMembers.classList.remove('hidden');
            hideAddToCard();
        }
        function hideMembers() {
            popupMembers.classList.add('hidden');
        }

        // Attach popup
        const popupAttach = document.getElementById('popup-attach');
        function showAttach() {
            popupAttach.classList.remove('hidden');
            hideAddToCard();
        }
        function hideAttach() {
            popupAttach.classList.add('hidden');
        }

        // Add to card popup
        const popupAddToCard = document.getElementById('popup-add-to-card');
        function hideAddToCard() {
            popupAddToCard.classList.add('hidden');
        }

        // Expose hide/show functions to global scope
        window.hideAddToCard = hideAddToCard;
        window.showLabels = showLabels;
        window.hideLabels = hideLabels;
        window.showAttach = showAttach;
        window.hideAttach = hideAttach;
        window.showDates = showDates;
        window.hideDates = hideDates;
        window.showChecklist = showChecklist;
        window.hideChecklist = hideChecklist;
        window.showMembers = showMembers;
        window.hideMembers = hideMembers;
        function renderCalendar() {
            const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            calLabel && (calLabel.textContent = `${months[calMonth]} ${calYear}`);
            if (!calDays) return;
            calDays.innerHTML = '';
            const first = new Date(calYear, calMonth, 1);
            const startIndex = (first.getDay() + 6) % 7; // convert Sunday(0) to 6 for Mon-first
            const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
            for (let i = 0; i < startIndex; i++) {
                const span = document.createElement('span');
                span.className = 'text-[#9fadbc]';
                span.textContent = '';
                calDays.appendChild(span);
            }
            for (let d = 1; d <= daysInMonth; d++) {
                const btn = document.createElement('button');
                btn.className = 'rounded hover:bg-[#384148] px-2 py-1';
                btn.textContent = String(d);
                btn.onclick = () => {
                    const mm = String(calMonth + 1).padStart(2, '0');
                    const dd = String(d).padStart(2, '0');
                    const yyyy = calYear;
                    const isoDate = `${yyyy}-${mm}-${dd}`;
                    const display = `${dd}/${mm}/${yyyy}`;
                    if (calendarTarget === 'start') {
                        startDateToggle && (startDateToggle.checked = true);
                        startDateInput && (startDateInput.value = display);
                        currentStartDate = new Date(`${isoDate}T00:00:00`).toISOString();
                    } else {
                        dueDateToggle && (dueDateToggle.checked = true);
                        dueTimeInput && (dueTimeInput.value = dueTimeInput.value || '00:00');
                        dateInput && (dateInput.value = display);
                        const t = (dueTimeInput?.value || '00:00');
                        const combined = new Date(`${isoDate}T${t}:00`);
                        currentDueDate = isNaN(combined) ? null : combined.toISOString();
                    }
                };
                calDays.appendChild(btn);
            }
        }
        calPrev?.addEventListener('click', () => { calMonth -= 1; if (calMonth < 0) { calMonth = 11; calYear -= 1; } renderCalendar(); });
        calNext?.addEventListener('click', () => { calMonth += 1; if (calMonth > 11) { calMonth = 0; calYear += 1; } renderCalendar(); });
        calPrevYear?.addEventListener('click', () => { calYear -= 1; renderCalendar(); });
        calNextYear?.addEventListener('click', () => { calYear += 1; renderCalendar(); });
        startDateInput?.addEventListener('focus', () => { calendarTarget = 'start'; });
        dateInput?.addEventListener('focus', () => { calendarTarget = 'due'; });

        function wrapSelectionInTextarea(tx, before, after) {
            const start = tx.selectionStart ?? 0;
            const end = tx.selectionEnd ?? 0;
            const value = tx.value ?? '';
            const selected = value.slice(start, end);
            const newText = value.slice(0, start) + before + selected + after + value.slice(end);
            tx.value = newText;
            tx.setSelectionRange(start + before.length, end + before.length);
            tx.dispatchEvent(new Event('input'));
        }
        function makeList(tx) {
            const start = tx.selectionStart ?? 0;
            const end = tx.selectionEnd ?? 0;
            const value = tx.value ?? '';
            const before = value.slice(0, start);
            const selected = value.slice(start, end);
            const after = value.slice(end);
            const lines = selected.split('\n').map(l => (l.trim().length ? `- ${l}` : l)).join('\n');
            tx.value = before + lines + after;
            tx.setSelectionRange(start, start + lines.length);
            tx.dispatchEvent(new Event('input'));
        }
        document.getElementById('btn-desc-bold')?.addEventListener('click', () => wrapSelectionInTextarea(descInput, '**', '**'));
        document.getElementById('btn-desc-italic')?.addEventListener('click', () => wrapSelectionInTextarea(descInput, '*', '*'));
        document.getElementById('btn-desc-code')?.addEventListener('click', () => wrapSelectionInTextarea(descInput, '`', '`'));
        document.getElementById('btn-desc-ul')?.addEventListener('click', () => makeList(descInput));
        document.getElementById('btn-desc-link')?.addEventListener('click', () => {
            const url = prompt('Enter URL') || '';
            if (!url) return;
            wrapSelectionInTextarea(descInput, '[', `](${url})`);
        });
        document.getElementById('btn-desc-image')?.addEventListener('click', () => {
            const url = prompt('Enter image URL') || '';
            if (!url) return;
            const start = descInput.selectionStart ?? 0;
            const end = descInput.selectionEnd ?? 0;
            const value = descInput.value ?? '';
            const alt = value.slice(start, end) || 'image';
            const newText = value.slice(0, start) + `![${alt}](${url})` + value.slice(end);
            descInput.value = newText;
            descInput.setSelectionRange(start, start + `![${alt}](${url})`.length);
            descInput.dispatchEvent(new Event('input'));
        });
        commentInput?.addEventListener('focus', () => commentToolbar && commentToolbar.classList.remove('hidden'));
        commentInput?.addEventListener('blur', () => commentToolbar && commentToolbar.classList.add('hidden'));
        commentInput?.addEventListener('input', () => {
            if (!btnCommentSave) return;
            const hasText = (commentInput.value || '').trim().length > 0;
            btnCommentSave.disabled = !hasText;
            commentActions && commentActions.classList.remove('hidden');
        });
        document.getElementById('btn-comment-bold')?.addEventListener('click', () => wrapSelectionInTextarea(commentInput, '**', '**'));
        document.getElementById('btn-comment-italic')?.addEventListener('click', () => wrapSelectionInTextarea(commentInput, '*', '*'));
        document.getElementById('btn-comment-code')?.addEventListener('click', () => wrapSelectionInTextarea(commentInput, '`', '`'));
        document.getElementById('btn-comment-ul')?.addEventListener('click', () => makeList(commentInput));
        document.getElementById('btn-comment-link')?.addEventListener('click', () => {
            const url = prompt('Enter URL') || '';
            if (!url) return;
            wrapSelectionInTextarea(commentInput, '[', `](${url})`);
        });
        document.getElementById('btn-comment-image')?.addEventListener('click', () => {
            const url = prompt('Enter image URL') || '';
            if (!url) return;
            const start = commentInput.selectionStart ?? 0;
            const end = commentInput.selectionEnd ?? 0;
            const value = commentInput.value ?? '';
            const alt = value.slice(start, end) || 'image';
            const newText = value.slice(0, start) + `![${alt}](${url})` + value.slice(end);
            commentInput.value = newText;
            commentInput.setSelectionRange(start, start + `![${alt}](${url})`.length);
            commentInput.dispatchEvent(new Event('input'));
        });
        btnCommentSave?.addEventListener('click', () => {
            const text = (commentInput.value || '').trim();
            if (!text) return;
            addActivity(text, true);
            commentInput.value = '';
            btnCommentSave.disabled = true;
            commentToolbar && commentToolbar.classList.add('hidden');
            commentActions && commentActions.classList.add('hidden');
        });
        btnCommentCancel?.addEventListener('click', () => {
            commentInput.value = '';
            btnCommentSave && (btnCommentSave.disabled = true);
            commentToolbar && commentToolbar.classList.add('hidden');
            commentActions && commentActions.classList.add('hidden');
        });
        // Date helpers
        function syncDateInput() {
            const dateDisplay = document.getElementById('date-display-value');
            const btnHeader = document.getElementById('btn-header-dates');
            const badgeEl = document.getElementById('date-display-badge');

            if (startDateToggle) startDateToggle.checked = !!currentStartDate;
            if (startDateInput && currentStartDate) {
                const s = new Date(currentStartDate);
                if (!isNaN(s)) {
                    const yyyy = s.getFullYear();
                    const mm = String(s.getMonth() + 1).padStart(2, '0');
                    const dd = String(s.getDate()).padStart(2, '0');
                    startDateInput.value = `${dd}/${mm}/${yyyy}`;
                }
            } else if (startDateInput) {
                startDateInput.value = '';
            }

            if (currentDueDate || currentStartDate) {
                const fmtShort = new Intl.DateTimeFormat('en-GB', { day: 'numeric', month: 'short' });
                
                if (dateDisplay) {
                    let text = '';
                    if (currentStartDate) {
                        const s = new Date(currentStartDate);
                        text += fmtShort.format(s);
                    }
                    
                    if (currentDueDate) {
                        const d = new Date(currentDueDate);
                        const time = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        if (text) text += ' - ';
                        text += `${fmtShort.format(d)}, ${time}`; // Use comma to separate date and time more clearly? Or keep space?
                        // Original was: `${fmtShort.format(d)} • ${time}` for single date
                        // Range was: `${sFmt} - ${dFmt}, ${time}`
                        
                        // Let's stick to consistent format
                        if (currentStartDate) {
                             // Range
                             const dFmt = fmtShort.format(d);
                             text = `${fmtShort.format(new Date(currentStartDate))} - ${dFmt}, ${time}`;
                        } else {
                             // Due date only
                             text = `${fmtShort.format(d)} • ${time}`;
                        }
                    } else {
                        // Start date only - what should we show? Just the date.
                        // And maybe "Starts: ..."
                        text = `Starts: ${text}`;
                    }
                    dateDisplay.innerText = text;
                }

                if (currentDueDate) {
                    const d = new Date(currentDueDate);
                    if (!isNaN(d)) {
                         const yyyy = d.getFullYear();
                         const mm = String(d.getMonth() + 1).padStart(2, '0');
                         const dd = String(d.getDate()).padStart(2, '0');
                         const hh = String(d.getHours()).padStart(2, '0');
                         const mi = String(d.getMinutes()).padStart(2, '0');
                         dateInput.value = `${dd}/${mm}/${yyyy}`;
                         dueTimeInput.value = `${hh}:${mi}`;
                         
                         if (badgeEl) {
                            const now = new Date();
                            const diffHours = (d.getTime() - now.getTime()) / 3600000;
                            if (currentCompleted) {
                                badgeEl.innerText = 'Complete';
                                badgeEl.className = 'bg-[#4bce97] text-[#1d2125] text-[10px] font-bold px-1.5 rounded-sm uppercase ml-1';
                            } else if (diffHours <= 48 && diffHours > 0) {
                                badgeEl.innerText = 'Due soon';
                                badgeEl.className = 'bg-[#e2b203] text-[#1d2125] text-[10px] font-bold px-1.5 rounded-sm uppercase ml-1';
                            } else if (diffHours < 0) {
                                badgeEl.innerText = 'Overdue';
                                badgeEl.className = 'bg-[#ae2e24] text-white text-[10px] font-bold px-1.5 rounded-sm uppercase ml-1';
                            } else {
                                badgeEl.innerText = 'Due date';
                                badgeEl.className = 'bg-[#2c333a] text-[#b6c2cf] text-[10px] font-bold px-1.5 rounded-sm uppercase ml-1';
                            }
                            badgeEl.style.display = 'inline-block';
                        }
                    }
                } else {
                     // No due date, hide badge or show specific badge for start date?
                     // Hide badge for now if only start date
                     if (badgeEl) badgeEl.style.display = 'none';
                     
                     // Reset inputs to default/now if not set, but don't overwrite if user is typing?
                     // Actually syncDateInput is usually called on load or save, so resetting is fine.
                     const now = new Date();
                     const yyyy = now.getFullYear();
                     const mm = String(now.getMonth() + 1).padStart(2, '0');
                     const dd = String(now.getDate()).padStart(2, '0');
                     dateInput.value = `${dd}/${mm}/${yyyy}`;
                     dueTimeInput.value = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
                }

                document.getElementById('dates-display-section').classList.remove('hidden');
                if (btnHeader) btnHeader.classList.add('hidden');
            } else {
                const now = new Date();
                const yyyy = now.getFullYear();
                const mm = String(now.getMonth() + 1).padStart(2, '0');
                const dd = String(now.getDate()).padStart(2, '0');
                dateInput.value = `${dd}/${mm}/${yyyy}`;
                dueTimeInput.value = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
                document.getElementById('dates-display-section').classList.add('hidden');
                if (btnHeader) btnHeader.classList.remove('hidden');
            }
        }
        // Complete toggle (modal)
        function renderCompleteModal() {
            const btn = document.getElementById('btn-complete-modal');
            if (!btn) return;
            btn.title = currentCompleted ? 'Mark incomplete' : 'Mark complete';
            if (currentCompleted) {
                btn.className = 'mt-1.5 w-6 h-6 rounded-full bg-[#4bce97] flex items-center justify-center text-[#1d2125] text-xs font-bold flex-shrink-0';
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
            } else {
                btn.className = 'mt-1.5 w-6 h-6 rounded-full border border-[#9fadbc] flex items-center justify-center text-[#b6c2cf] text-xs font-bold flex-shrink-0';
                btn.innerHTML = '';
            }
        }
        document.getElementById('btn-complete-modal')?.addEventListener('click', () => {
            currentCompleted = !currentCompleted;
            renderCompleteModal();
            scheduleAutoSave();
            const author = getAssignedAuthor();
            const msg = currentCompleted ? 'marked this card as complete' : 'marked this card as incomplete';
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const el = document.createElement('div');
            el.className = 'text-sm text-[#b6c2cf] flex items-start gap-2';
            el.innerHTML = `<div class="w-6 h-6 rounded-full bg-[#705dfe] border-2 border-[#22272b] flex items-center justify-center text-[10px] font-bold text-white uppercase">${author.initials || 'Y'}</div><div class="flex-1"><div class="text-[11px] text-[#9fadbc]"><span class="font-semibold">${author.name}</span> ${msg}</div><div class="text-[11px] text-[#9fadbc]">${time}</div></div>`;
            commentsContainer?.prepend(el);
        });
        // Autosave helpers
        let saveTimer = null;
        let autosaveBound = false;
        function buildPayloadForSave() {
            return {
                title: (titleInput.value || '').trim() || 'Untitled',
                description: (descInput.value || '').trim() || null,
                list_key: currentList || 'today',
                due_date: currentDueDate,
                start_date: currentStartDate,
                completed: currentCompleted,
                labels: selectedLabels,
                members: selectedMembers,
                checklist: checklistItems,
                attachments: attachments,
            };
        }
        function scheduleAutoSave() {
            if (!currentCard || !currentCard.id) return;
            clearTimeout(saveTimer);
            saveTimer = setTimeout(async () => {
                try {
                    const url = `{{ url('/developer/board/cards') }}/${currentCard.id}`;
                    const payload = buildPayloadForSave();
                    const res = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });
                    if (!res.ok) {
                        const err = await res.json().catch(() => ({}));
                        throw new Error(err.message || 'Failed to save card');
                    }
                    const updated = await res.json();
                    currentCard = updated;
                    loadCards();
                } catch (e) {
                    console.warn('Autosave gagal:', e);
                }
            }, 500);
        }
        btnDateSave?.addEventListener('click', () => {
            const datePart = (dateInput.value || '').trim();
            const timePart = (dueTimeInput.value || '00:00').trim();

            if (startDateToggle && startDateToggle.checked && startDateInput) {
                const val = startDateInput.value.trim();
                if (val) {
                    const [dd, mm, yyyy] = val.split('/');
                    if (dd && mm && yyyy) {
                        const s = new Date(`${yyyy}-${mm}-${dd}`);
                        if (!isNaN(s)) {
                            currentStartDate = s.toISOString();
                        }
                    }
                }
            } else {
                currentStartDate = null;
            }

            if (dueDateToggle?.checked) {
                if (dateInput.value) {
                     const val = dateInput.value.trim();
                     const [dd, mm, yyyy] = val.split('/');
                     const [hh, mi] = timePart.split(':');
                     if (dd && mm && yyyy) {
                         const d = new Date(`${yyyy}-${mm}-${dd}`);
                         if (!isNaN(d)) {
                             d.setHours(Number(hh || 0), Number(mi || 0), 0, 0);
                             currentDueDate = d.toISOString();
                         }
                     }
                } else if (currentDueDate) {
                    // Fallback to existing currentDueDate if input is empty but variable is set?
                    // Actually if input is empty but toggle is checked, user probably wants to set it?
                    // But if input is empty, how can we set it?
                    // Let's assume input always has value if toggle is checked because of syncDateInput defaults
                    const d = new Date(currentDueDate);
                    const [hh, mi] = timePart.split(':');
                    if (!isNaN(d) && hh !== undefined) {
                        d.setHours(Number(hh), Number(mi || 0), 0, 0);
                        currentDueDate = d.toISOString();
                    }
                }
            } else {
                currentDueDate = null;
            }
            syncDateInput();
            hideDates();
            scheduleAutoSave();
        });
        dueTimeInput?.addEventListener('change', () => {
            const timePart = (dueTimeInput.value || '00:00').trim();
            if (currentDueDate) {
                const d = new Date(currentDueDate);
                const [hh, mi] = timePart.split(':');
                if (!isNaN(d) && hh !== undefined) {
                    d.setHours(Number(hh), Number(mi || 0), 0, 0);
                    currentDueDate = d.toISOString();
                }
            }
        });
        btnDateRemove?.addEventListener('click', () => {
            currentDueDate = null;
            dateInput && (dateInput.value = '');
            dueTimeInput && (dueTimeInput.value = '');
            currentStartDate = null;
            startDateInput && (startDateInput.value = '');
            document.getElementById('dates-display-section').classList.add('hidden');
            hideDates();
            scheduleAutoSave();
        });

        // completion toggle helpers
        async function toggleComplete(cardData, nextValue) {
            try {
                const response = await fetch(`{{ url('/developer/board/cards') }}/${cardData.id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ completed: nextValue }),
                });
                if (!response.ok) throw new Error('Failed to update status');
                return await response.json();
            } catch (err) {
                alert('Gagal update status: ' + err.message);
                return null;
            }
        }

        function attachCardHandlers(cardEl, cardData) {
            const btn = cardEl.querySelector('[aria-label="complete-toggle"]');
            if (btn) {
                btn.onclick = async () => {
                    const next = !cardData.completed;
                    const updated = await toggleComplete(cardData, next);
                    if (updated) {
                        cardData.completed = updated.completed;
                        const newEl = createCardElement(cardData);
                        attachCardHandlers(newEl, cardData);
                        cardEl.replaceWith(newEl);
                    }
                };
            }
            // open detail modal when clicking card (except complete button)
            cardEl.style.cursor = 'pointer';
            cardEl.addEventListener('click', (e) => {
                if (e.target.closest('[aria-label="complete-toggle"]')) return;
                openModalFromCard(cardData);
            });
        }

        // Label picker
        function renderLabelOptions() {
            labelsListEl.innerHTML = '';
            LABEL_OPTIONS.forEach(opt => {
                const row = document.createElement('button');
                row.type = 'button';
                row.dataset.key = opt.key;
                row.className = `${opt.class} w-full flex items-center justify-between px-2 py-1 rounded text-xs text-white bg-opacity-90 hover:bg-opacity-100 transition`;
                const checked = selectedLabels.includes(opt.key) ? '✓' : '';
                row.innerHTML = `<span>${opt.name}</span><span>${checked}</span>`;
                row.onclick = () => {
                    toggleLabel(opt.key);
                };
                labelsListEl.appendChild(row);
            });
        }
        function toggleLabel(key) {
            if (selectedLabels.includes(key)) {
                selectedLabels = selectedLabels.filter(k => k !== key);
            } else {
                selectedLabels.push(key);
            }
            renderLabelOptions();
            renderSelectedLabels();
            scheduleAutoSave();
        }
        renderLabelOptions();
        renderSelectedLabels();

        // Checklist handlers
        function renderChecklist() {
            checklistContainer.innerHTML = '';
            const section = document.getElementById('checklist-section');
            const btnHeader = document.getElementById('btn-header-checklist');
            
            if (!checklistItems.length) {
                section.classList.add('hidden');
                if(btnHeader) btnHeader.classList.remove('hidden');
                return;
            }
            section.classList.remove('hidden');
            if(btnHeader) btnHeader.classList.add('hidden');
            
            // Calculate progress
            const total = checklistItems.length;
            const done = checklistItems.filter(i => i.done).length;
            const percentage = total === 0 ? 0 : Math.round((done / total) * 100);
            
            const progressBar = document.getElementById('checklist-progress-bar');
            if (progressBar) {
                progressBar.style.width = `${percentage}%`;
                // Update text if exists
                const progressText = progressBar.parentElement.previousElementSibling;
                if (progressText && progressText.tagName === 'SPAN') {
                    progressText.innerText = `${percentage}%`;
                }
            }

            checklistItems.forEach((item, idx) => {
                const row = document.createElement('div');
                row.className = 'flex items-center gap-2 text-sm text-[#b6c2cf] hover:bg-[#A6C5E229] p-1.5 rounded -ml-1.5 group';
                row.innerHTML = `
                    <input type="checkbox" class="h-4 w-4 bg-[#22272b] border-[#2c333a] rounded accent-[#579dff] flex-shrink-0" ${item.done ? 'checked' : ''} data-idx="${idx}">
                    <span class="flex-1 ${item.done ? 'line-through text-[#9fadbc]' : ''}">${item.text}</span>
                    <button data-remove="${idx}" class="text-[#9fadbc] hover:text-[#b6c2cf] opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                `;
                checklistContainer.appendChild(row);
            });
            checklistContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.onchange = (e) => {
                    const i = Number(e.target.dataset.idx);
                    checklistItems[i].done = e.target.checked;
                    renderChecklist();
                    scheduleAutoSave();
                };
            });
            checklistContainer.querySelectorAll('button[data-remove]').forEach(btn => {
                btn.onclick = () => {
                    const i = Number(btn.dataset.remove);
                    checklistItems.splice(i, 1);
                    renderChecklist();
                    scheduleAutoSave();
                };
            });
        }
        
        // Toggle checklist input visibility
        window.showChecklistInput = function() {
            document.getElementById('btn-show-checklist-input').classList.add('hidden');
            document.getElementById('checklist-input-wrapper').classList.remove('hidden');
            document.getElementById('checklist-input-wrapper').classList.add('flex');
            document.getElementById('checklist-input').focus();
        };
        window.hideChecklistInput = function() {
            document.getElementById('checklist-input-wrapper').classList.add('hidden');
            document.getElementById('checklist-input-wrapper').classList.remove('flex');
            document.getElementById('btn-show-checklist-input').classList.remove('hidden');
        };

        btnChecklistAdd?.addEventListener('click', () => {
            const text = (checklistInput.value || '').trim();
            if (!text) return;
            checklistItems.push({ text, done: false });
            checklistInput.value = '';
            renderChecklist();
            // Keep input open
            checklistInput.focus();
            scheduleAutoSave();
        });

        checklistInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnChecklistAdd.click();
            } else if (e.key === 'Escape') {
                hideChecklistInput();
            }
        });

        // Popup checklist add button
        const btnChecklistPopupAdd = document.getElementById('btn-checklist-popup-add');
        const checklistPopupInput = document.getElementById('checklist-popup-input');
        btnChecklistPopupAdd?.addEventListener('click', () => {
            const text = (checklistPopupInput.value || '').trim();
            if (!text) return;
            checklistItems.push({ text, done: false });
            checklistPopupInput.value = '';
            document.getElementById('checklist-section').classList.remove('hidden');
            renderChecklist();
            hideChecklist();
            scheduleAutoSave();
        });

        // Attachment handlers
        function renderAttachments() {
            attachList.innerHTML = '';
            const section = document.getElementById('attachment-section');
            const btnHeader = document.getElementById('btn-header-attach');

            if (!attachments.length) {
                section.classList.add('hidden');
                if(btnHeader) btnHeader.classList.remove('hidden');
                return;
            }
            section.classList.remove('hidden');
            if(btnHeader) btnHeader.classList.add('hidden');

            attachments.forEach((att, idx) => {
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 hover:bg-[#A6C5E229] p-2 rounded cursor-pointer group';
                const thumb = `
                    <div class="relative w-40 h-28 rounded overflow-hidden">
                        <img src="${att.url}" alt="${att.name}" class="w-40 h-28 object-cover" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        <div class="absolute inset-0 hidden bg-[#b6c2cf] flex items-center justify-center text-[#1d2125] font-bold text-xl">IMG</div>
                    </div>
                `;
                const meta = `Added ${new Date().toLocaleDateString('en-US')}${idx===0 ? ' • <span class="bg-[#A6C5E229] text-[#9fadbc] px-1 rounded text-[10px]">Cover</span>' : ''}`;
                row.innerHTML = `
                    ${thumb}
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-[#b6c2cf] text-sm truncate">${att.name}</div>
                        <div class="text-xs text-[#9fadbc]">${meta}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="${att.url}" target="_blank" class="text-[#9fadbc] hover:text-[#b6c2cf]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </a>
                        <button data-remove-att="${idx}" class="text-[#9fadbc] hover:text-[#b6c2cf]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                `;
                attachList.appendChild(row);
            });
            attachList.querySelectorAll('button[data-remove-att]').forEach(btn => {
                btn.onclick = () => {
                    const i = Number(btn.dataset.removeAtt);
                    attachments.splice(i, 1);
                    renderAttachments();
                    scheduleAutoSave();
                };
            });
        }
        btnAttachAdd?.addEventListener('click', () => {
            const name = (attachName.value || '').trim();
            const url = (attachUrl.value || '').trim();
            if (!name || !url) return;
            attachments.push({ name, url });
            attachName.value = '';
            attachUrl.value = '';
            renderAttachments();
            scheduleAutoSave();
        });

        // Popup attach choose button
        const btnAttachPopupChoose = document.getElementById('btn-attach-popup-choose');
        const attachFileInput = document.getElementById('attach-file-input');
        const btnAttachInsert = document.getElementById('btn-attach-insert');
        const attachLinkInput = document.getElementById('attach-link-input');
        const attachDisplayInput = document.getElementById('attach-display-input');
        btnAttachPopupChoose?.addEventListener('click', () => {
            attachFileInput?.click();
        });
        attachFileInput?.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (!file) return;
            const name = file.name || 'Attachment';
            const reader = new FileReader();
            reader.onload = () => {
                const url = reader.result;
                attachments.push({ name, url });
                document.getElementById('attachment-section').classList.remove('hidden');
                hideAttach();
                renderAttachments();
                scheduleAutoSave();
            };
            reader.readAsDataURL(file);
        });
        btnAttachInsert?.addEventListener('click', () => {
            const url = (attachLinkInput?.value || '').trim();
            const name = (attachDisplayInput?.value || '').trim() || url;
            if (!url) return;
            attachments.push({ name, url });
            document.getElementById('attachment-section').classList.remove('hidden');
            hideAttach();
            renderAttachments();
            scheduleAutoSave();
        });

        // Members handlers
        function renderMembers() {
            const container = document.getElementById('members-list');
            const section = document.getElementById('members-display-section');
            const btnHeader = document.getElementById('btn-header-members');
            if (!container) return;
            container.innerHTML = '';
            
            if (!selectedMembers.length) {
                section.classList.add('hidden');
                if(btnHeader) btnHeader.classList.remove('hidden');
                return;
            }
            section.classList.remove('hidden');
            if(btnHeader) btnHeader.classList.add('hidden');

            selectedMembers.forEach(m => {
                const el = document.createElement('div');
                el.className = 'w-8 h-8 rounded-full bg-[#705dfe] flex items-center justify-center text-xs font-bold text-white uppercase cursor-pointer hover:opacity-80';
                el.innerText = m.initials || 'Y';
                el.title = m.name || 'User';
                container.appendChild(el);
            });
            
            // Add button circle
            const addBtn = document.createElement('button');
            addBtn.className = 'w-8 h-8 rounded-full bg-[#2c333a] hover:bg-[#384148] flex items-center justify-center text-[#b6c2cf] transition-colors';
            addBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
            addBtn.onclick = showMembers;
            container.appendChild(addBtn);
        }

        function renderSelectedLabels() {
            const container = document.getElementById('labels-display-list');
            const section = document.getElementById('labels-display-section');
            const btnHeader = document.getElementById('btn-header-labels');
            if (!container) return;
            
            container.innerHTML = '';

            if (!selectedLabels.length) {
                section.classList.add('hidden');
                if(btnHeader) btnHeader.classList.remove('hidden');
                return;
            }
            section.classList.remove('hidden');
            if(btnHeader) btnHeader.classList.add('hidden');

            selectedLabels.forEach(key => {
                const opt = LABEL_OPTIONS.find(o => o.key === key);
                if (opt) {
                     const el = document.createElement('div');
                     el.className = `${opt.class} h-8 px-3 rounded text-sm font-semibold text-white flex items-center justify-center cursor-pointer hover:opacity-80`;
                     el.innerText = opt.name;
                     el.onclick = showLabels;
                     container.appendChild(el);
                }
            });

            // Add button
            const addBtn = document.createElement('button');
            addBtn.className = 'w-8 h-8 rounded bg-[#2c333a] hover:bg-[#384148] flex items-center justify-center text-[#b6c2cf] transition-colors';
            addBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';
            addBtn.onclick = showLabels;
            container.appendChild(addBtn);
        }

        const btnAddMemberCurrent = document.getElementById('btn-add-member-current');
        const currentMemberNameEl = document.getElementById('current-member-name');
        const currentMemberInitialsEl = document.getElementById('current-member-initials');
        currentMemberNameEl && (currentMemberNameEl.textContent = CURRENT_USER.name);
        currentMemberInitialsEl && (currentMemberInitialsEl.textContent = CURRENT_INITIALS);
        btnAddMemberCurrent?.addEventListener('click', () => {
            const existing = selectedMembers.find(m => m.id === CURRENT_USER.id);
            if (existing) {
                selectedMembers = selectedMembers.filter(m => m.id !== CURRENT_USER.id);
            } else {
                selectedMembers.push({ id: CURRENT_USER.id, name: CURRENT_USER.name, initials: CURRENT_INITIALS });
            }
            renderMembers();
            scheduleAutoSave();
            const author = getAssignedAuthor();
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const el = document.createElement('div');
            el.className = 'text-sm text-[#b6c2cf] flex items-start gap-2';
            el.innerHTML = `<div class="w-6 h-6 rounded-full bg-[#705dfe] border-2 border-[#22272b] flex items-center justify-center text-[10px] font-bold text-white uppercase">${author.initials || 'Y'}</div><div class="flex-1"><div class="text-[11px] text-[#9fadbc]"><span class="font-semibold">${author.name}</span> joined this card</div><div class="text-[11px] text-[#9fadbc]">${time}</div></div>`;
            commentsContainer?.prepend(el);
        });

        // Load cards on start
        async function loadCards() {
            try {
                const response = await fetch('{{ route('developer.cards.index') }}', {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load cards');
                const cards = await response.json();
                todayContainer.innerHTML = '';
                weekContainer.innerHTML = '';
                laterContainer.innerHTML = '';
                cards.forEach((c) => {
                    const cardEl = createCardElement(c);
                    attachCardHandlers(cardEl, c);
                    if (c.list_key === 'weekly') {
                        weekContainer.appendChild(cardEl);
                    } else if (c.list_key === 'later') {
                        laterContainer.appendChild(cardEl);
                    } else {
                        todayContainer.appendChild(cardEl);
                    }
                });
            } catch (err) {
                console.error(err);
            }
        }

        document.addEventListener('DOMContentLoaded', loadCards);
    </script>
    <!-- Delete Confirmation Popover -->
    <div id="delete-confirm-popover" class="hidden fixed z-[100] bg-[#282e33] border border-[#3b444c] rounded-lg shadow-xl w-72 p-0 text-[#b6c2cf]">
        <div class="flex justify-between items-center p-4 pb-2">
             <span class="font-semibold text-sm text-center w-full">Delete comment?</span>
             <button onclick="hideDeletePopover()" class="text-[#9fadbc] hover:text-white absolute right-4 top-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
        </div>
        <div class="px-4 pb-4">
            <p class="text-sm mb-4">Deleting a comment is forever. There is no undo.</p>
            <button onclick="performDelete()" class="w-full bg-[#f87168] hover:bg-[#fe8f8f] text-[#1d2125] font-semibold py-1.5 rounded-[3px] text-sm">Delete comment</button>
        </div>
    </div>

    <script>
        function toggleList(contentId, chevronId) {
            // Hanya aktif di mobile (bisa dicek dengan window.innerWidth atau simply biarkan css md:hidden menghandle icon)
            // Tapi karena function ini dipanggil onclick div, kita perlu cek apakah sedang di mobile atau tidak agar tidak mengganggu desktop jika user klik header.
            if (window.innerWidth >= 768) return; 

            const content = document.getElementById(contentId);
            const chevron = document.getElementById(chevronId);
            
            content.classList.toggle('hidden');
            
            if (content.classList.contains('hidden')) {
                chevron.style.transform = 'rotate(0deg)';
            } else {
                chevron.style.transform = 'rotate(180deg)';
            }
        }
    </script>
</body>
</html>
