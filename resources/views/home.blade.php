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
    <div style="background-color: #e5e7eb; min-height: 60vh; display: flex; align-items: center; justify-content: center; position: relative; padding: 3rem 1rem;">
        <div style="max-width: 1280px; width: 100%;">
            <!-- Carousel Container -->
            <div style="position: relative;">
                <!-- Carousel Arrow Left -->
                <button id="carousel-prev" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.8); border: none; border-radius: 50%; padding: 0.5rem; cursor: pointer; transition: background 0.3s;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #1f2937;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Carousel Arrow Right -->
                <button id="carousel-next" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,0.8); border: none; border-radius: 50%; padding: 0.5rem; cursor: pointer; transition: background 0.3s;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #1f2937;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Carousel Image -->
                <div style="overflow: hidden; border-radius: 0.5rem;">
                    <img id="carousel-image" 
                         src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=600&fit=crop" 
                         alt="Carousel Image" 
                         style="width: 100%; height: 500px; object-fit: cover; display: block;">
                </div>

                <!-- Carousel Indicators -->
                <div style="display: flex; justify-content: center; margin-top: 1rem; gap: 0.5rem;">
                    <button class="carousel-indicator" data-slide="0" style="width: 2rem; height: 0.25rem; background-color: white; border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                    <button class="carousel-indicator" data-slide="1" style="width: 2rem; height: 0.25rem; background-color: #9ca3af; border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                    <button class="carousel-indicator" data-slide="2" style="width: 2rem; height: 0.25rem; background-color: #9ca3af; border: none; border-radius: 0.25rem; cursor: pointer;"></button>
                </div>
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
