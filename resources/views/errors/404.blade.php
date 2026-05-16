<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Millenium</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col">
    <!-- Navbar (Simplified from Welcome Page) -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#8B1C3A] rounded-xl flex items-center justify-center shadow-lg">
                    <i data-lucide="utensils" class="w-6 h-6 text-white"></i>
                </div>
                <div class="font-playfair text-2xl font-bold tracking-tight text-[#8B1C3A]">
                    Mille<span class="text-[#D4A574]">nium</span>
                </div>
            </a>
            <a href="/" class="text-sm font-bold text-[#8B1C3A] hover:opacity-70 transition-opacity">
                Back to Home
            </a>
        </div>
    </nav>

    <!-- 404 Content -->
    <main class="flex-1 flex items-center justify-center p-6 bg-gradient-to-b from-white to-gray-50/50">
        <div class="max-w-2xl w-full text-center space-y-8">
            <div class="relative">
                <div class="text-[180px] font-black text-gray-100 select-none leading-none">404</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-24 h-24 bg-[#8B1C3A]/10 rounded-full flex items-center justify-center animate-bounce">
                        <i data-lucide="search" class="w-10 h-10 text-[#8B1C3A]"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h1 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                    Lost in <span class="text-[#8B1C3A]">Taste?</span>
                </h1>
                <p class="text-gray-500 text-lg max-w-md mx-auto">
                    The page you are looking for seems to have vanished from our menu. It may have been moved or removed.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a href="/" class="w-full sm:w-auto px-8 py-4 bg-[#8B1C3A] text-white font-bold rounded-2xl hover:bg-[#a01c3a] transition-all shadow-xl shadow-[#8B1C3A]/20 flex items-center justify-center group">
                    <i data-lucide="home" class="w-5 h-5 mr-2 group-hover:-translate-y-1 transition-transform"></i>
                    Return Home
                </a>
                <a href="/#menu" class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-gray-100 text-gray-900 font-bold rounded-2xl hover:bg-gray-50 transition-all flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5 mr-2 text-[#D4A574]"></i>
                    Explore Menu
                </a>
            </div>

            <!-- Suggestion Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-12 border-t border-gray-100">
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Reservations</h3>
                    <p class="text-xs text-gray-400">Book your table today</p>
                </div>
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Online Orders</h3>
                    <p class="text-xs text-gray-400">Delicious food delivered</p>
                </div>
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Contact Us</h3>
                    <p class="text-xs text-gray-400">We're here to help</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-8 text-center text-xs text-gray-400 border-t border-gray-100">
        <p>© {{ date('Y') }} Millenium Luxury Hospitality. All rights reserved.</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
