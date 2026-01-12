<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIX MONKEY'S</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar (Dark Blue) -->
    <nav style="background-color: #1e3a5f; color: white;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
                <div>
                    <h1 style="font-size: 1.25rem; font-weight: bold; text-transform: uppercase; margin: 0;">SIX MONKEY'S</h1>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @auth
                        <a href="{{ route('dashboard') }}" style="color: white; text-decoration: none; transition: color 0.3s;">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: white; cursor: pointer; transition: color 0.3s;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" style="color: white; text-decoration: none; transition: color 0.3s;">Sign Up</a>
                        <a href="{{ route('login') }}" style="color: white; text-decoration: none; transition: color 0.3s;">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Central Content Area (Light Gray with Carousel) -->
    <div style="background-color: #e5e7eb; position: relative;">
        <div style="width: 100%;">
            <!-- Carousel Container -->
            <div style="position: relative;">
                <!-- Carousel Arrow Left -->
                <button id="carousel-prev" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.8); border: none; border-radius: 50%; padding: 0.5rem; cursor: pointer; transition: background 0.3s;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #1f2937;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Carousel Arrow Right -->
                <button id="carousel-next" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.8); border: none; border-radius: 50%; padding: 0.5rem; cursor: pointer; transition: background 0.3s;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #1f2937;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Carousel Image -->
                <div style="overflow: hidden;">
                    <img id="carousel-image" 
                         src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&h=900&fit=crop" 
                         alt="Carousel Image" 
                         style="width: 100%; height: 70vh; object-fit: cover; display: block;">
                </div>

                <!-- Carousel Indicators -->
                <div style="display: flex; justify-content: center; position: absolute; bottom: 1rem; left: 0; right: 0; gap: 0.5rem;">
                    <button class="carousel-indicator" data-slide="0" style="width: 2rem; height: 0.25rem; background-color: white; border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                    <button class="carousel-indicator" data-slide="1" style="width: 2rem; height: 0.25rem; background-color: rgba(255,255,255,0.5); border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                    <button class="carousel-indicator" data-slide="2" style="width: 2rem; height: 0.25rem; background-color: rgba(255,255,255,0.5); border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                </div>
            </div>

            <!-- Robux Purchase Button -->
            <div style="width: 100%; padding: 2rem 8rem 2rem 2rem; display: flex; justify-content: flex-end; background-image: url('{{ asset('') }}'); background-size: cover; background-position: center;">
                <a href="{{ route('order.robux') }}" class="inline-flex bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 px-8 rounded-lg text-center text-lg shadow-lg transition duration-300 transform hover:-translate-y-1 items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    BELI ROBUX SEKARANG
                </a>
            </div>
        </div>
    </div>

    <!-- Lower Content Section (Dark Blue with 2 Columns) -->
    <div style="background-color: #1e3a5f; color: white; padding: 3rem 1rem;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
                <!-- Left Column - Company Profile -->
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Company Profile Six Monkey</h2>
                    <p style="color: #d1d5db; font-size: 1.125rem; margin: 0;">Isinya orang-orang keren dah pokonya</p>
                </div>

                <!-- Right Column - Projects -->
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Proyek kami</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Project Card 1 -->
                        <div style="background-color: #d1d5db; border-radius: 0.5rem; aspect-ratio: 1; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 5rem; height: 5rem; color: #4b5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <!-- Project Card 2 -->
                        <div style="background-color: #d1d5db; border-radius: 0.5rem; aspect-ratio: 1; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 5rem; height: 5rem; color: #4b5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel JavaScript -->
    <script>
        const carouselImages = [
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=600&fit=crop',
            'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1200&h=600&fit=crop',
            'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&h=600&fit=crop'
        ];
        
        let currentSlide = 0;
        const carouselImage = document.getElementById('carousel-image');
        const indicators = document.querySelectorAll('.carousel-indicator');
        
        function updateCarousel() {
            if (carouselImage) {
                carouselImage.src = carouselImages[currentSlide];
            }
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.style.backgroundColor = 'white';
                } else {
                    indicator.style.backgroundColor = '#9ca3af';
                }
            });
        }
        
        const nextBtn = document.getElementById('carousel-next');
        const prevBtn = document.getElementById('carousel-prev');
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % carouselImages.length;
                updateCarousel();
            });
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + carouselImages.length) % carouselImages.length;
                updateCarousel();
            });
        }
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                updateCarousel();
            });
        });
    </script>
</body>
</html>
