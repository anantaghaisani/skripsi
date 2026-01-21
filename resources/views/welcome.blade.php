<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakuna Matata Course - Bimbingan Belajar Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(135deg, #FFBF00 0%, #FFD700 100%);
            box-shadow: 0 4px 15px rgba(255, 191, 0, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 191, 0, 0.6);
        }
        .gradient-text {
            background: linear-gradient(135deg, #184E83 0%, #2563EB 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .wave-pattern {
            background: linear-gradient(135deg, #184E83 0%, #1E5FA8 100%);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo_hmc.png') }}" alt="HMC Logo" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-[#184E83]">Hakuna Matata</h1>
                        <p class="text-xs text-gray-600">Course</p>
                    </div>
                </div>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-[#184E83] font-medium transition">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-[#184E83] font-medium transition">Tentang</a>
                    <a href="#tentor" class="text-gray-700 hover:text-[#184E83] font-medium transition">Tentor</a>
                    <a href="#kontak" class="text-gray-700 hover:text-[#184E83] font-medium transition">Kontak</a>
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-[#184E83] hover:bg-[#0F3A5F] text-white font-semibold rounded-full transition">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-[#184E83]" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4 space-y-3">
                <a href="#beranda" class="block text-gray-700 hover:text-[#184E83] font-medium">Beranda</a>
                <a href="#tentang" class="block text-gray-700 hover:text-[#184E83] font-medium">Tentang</a>
                <a href="#tentor" class="block text-gray-700 hover:text-[#184E83] font-medium">Tentor</a>
                <a href="#kontak" class="block text-gray-700 hover:text-[#184E83] font-medium">Kontak</a>
                <a href="{{ route('login') }}" class="block w-full text-center px-6 py-2 bg-[#184E83] hover:bg-[#0F3A5F] text-white font-semibold rounded-full transition">
                    Login
                </a>
            </div>
        </div>
    </nav>

        <!-- Hero Section -->
    <section id="beranda" class="pt-24 pb-16 wave-pattern relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Raih Prestasi<br/>
                        <span class="text-[#FFBF00]">Tanpa Batas!</span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-100">
                        Bimbingan belajar terbaik untuk SD, SMP, dan SMA dengan metode pembelajaran yang menyenangkan dan efektif.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSenK5uHuv3jRGelG_nRNuO1TOXGkzIC2Z-lz0kdzDZjG2MR1g/viewform?pli=1" target="_blank" class="btn-primary px-8 py-4 text-[#184E83] font-bold rounded-full transition transform">
                            Daftar Sekarang
                        </a>
                        <a href="#tentang" class="px-8 py-4 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#184E83] transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Right Content - Illustration -->
                <div class="relative float-animation">
                    <!-- Hero Illustration with Size Control -->
                    <div class="max-w-md mx-auto">
                        <img src="{{ asset('images/logolengkapp.png') }}" 
                             alt="Hakuna Matata Course" 
                             class="w-full h-auto object-contain drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Bottom -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold text-[#184E83] mb-2">500+</div>
                    <p class="text-gray-600">Siswa Aktif</p>
                </div>
                <div>
                    <div class="text-5xl font-bold text-[#184E83] mb-2">15+</div>
                    <p class="text-gray-600">Tentor Berpengalaman</p>
                </div>
                <div>
                    <div class="text-5xl font-bold text-[#184E83] mb-2">95%</div>
                    <p class="text-gray-600">Tingkat Kelulusan</p>
                </div>
                <div>
                    <div class="text-5xl font-bold text-[#184E83] mb-2">10+</div>
                    <p class="text-gray-600">Tahun Pengalaman</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold gradient-text mb-4">Mengapa Hakuna Matata Course?</h2>
                <p class="text-xl text-gray-600">Metode pembelajaran yang terbukti efektif dan menyenangkan</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-[#FFBF00] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#184E83] mb-4">Kurikulum Terstruktur</h3>
                    <p class="text-gray-600">Materi pembelajaran disesuaikan dengan kurikulum nasional dan kebutuhan siswa.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-[#FFBF00] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#184E83] mb-4">Kelas Kecil</h3>
                    <p class="text-gray-600">Pembelajaran dengan rasio siswa-tentor ideal untuk perhatian maksimal.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-[#FFBF00] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#184E83] mb-4">Tryout Berkala</h3>
                    <p class="text-gray-600">Evaluasi rutin untuk memantau perkembangan dan kesiapan ujian.</p>
                </div>
            </div>
        </div>
    </section>

<!-- Tentor Section -->
<section id="tentor" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold gradient-text mb-4">Tentor Berpengalaman</h2>
            <p class="text-xl text-gray-600">Tim pengajar profesional yang siap membimbing kesuksesan Anda</p>
        </div>

        <!-- Carousel -->
        <div class="relative">
            <div
                id="tentorCarousel"
                class="flex gap-6 overflow-x-auto scroll-smooth pb-6 snap-x snap-mandatory scrollbar-hide"
            >
                <!-- Tentor Card -->
                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Miss Al.JPG') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Miss Al</h3>
                    <p class="text-gray-600 mb-2">Matematika & Fisika</p>
                    <p class="text-sm text-gray-500">S.Pd., M.Pd.</p>
                </div>

                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Bu Tutut.jpg') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Bu Tutut</h3>
                    <p class="text-gray-600 mb-2">Bahasa Inggris</p>
                    <p class="text-sm text-gray-500">S.Pd.</p>
                </div>

                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Bu May.JPG') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Bu May</h3>
                    <p class="text-gray-600 mb-2">Kimia & Biologi</p>
                    <p class="text-sm text-gray-500">S.Si., M.Si.</p>
                </div>

                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Pak Eko.JPG') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Pak Eko</h3>
                    <p class="text-gray-600 mb-2">IPS & Ekonomi</p>
                    <p class="text-sm text-gray-500">S.E., M.M.</p>
                </div>

                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Bu Ima.JPG') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Bu Ima</h3>
                    <p class="text-gray-600 mb-2">Bahasa Indonesia</p>
                    <p class="text-sm text-gray-500">S.Pd.</p>
                </div>

                <div class="tentor-card flex-shrink-0 w-72 text-center snap-center">
                    <img src="{{ asset('images/Pak Rizal.JPG') }}" class="w-48 h-48 rounded-full mx-auto mb-4 object-cover border-4 border-[#FFBF00] shadow-lg">
                    <h3 class="text-xl font-bold text-[#184E83] mb-2">Pak Rizal</h3>
                    <p class="text-gray-600 mb-2">Matematika</p>
                    <p class="text-sm text-gray-500">S.Pd.</p>
                </div>
            </div>

            <!-- Dots -->
            <div id="tentorDots" class="flex justify-center gap-2 mt-8"></div>

            <p class="text-center text-gray-500 text-sm mt-4 md:hidden">
                ← Geser untuk melihat tentor lainnya →
            </p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('tentorCarousel');
    const cards = carousel.querySelectorAll('.tentor-card');
    const dotsContainer = document.getElementById('tentorDots');

    const itemsPerPage = 4;
    const totalPages = Math.ceil(cards.length / itemsPerPage);

    // Create dots
    for (let i = 0; i < totalPages; i++) {
        const dot = document.createElement('button');
        dot.className = `
            h-2 rounded-full transition-all duration-300
            ${i === 0 ? 'w-8 bg-[#184E83]' : 'w-2 bg-gray-300'}
        `;
        dot.addEventListener('click', () => {
            const targetCard = cards[i * itemsPerPage];
            targetCard.scrollIntoView({ behavior: 'smooth', inline: 'start' });
            setActiveDot(i);
        });
        dotsContainer.appendChild(dot);
    }

    const dots = dotsContainer.querySelectorAll('button');

    function setActiveDot(activeIndex) {
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-[#184E83]', i === activeIndex);
            dot.classList.toggle('bg-gray-300', i !== activeIndex);
            dot.classList.toggle('w-8', i === activeIndex);
            dot.classList.toggle('w-2', i !== activeIndex);
        });
    }

    carousel.addEventListener('scroll', () => {
        const cardWidth = cards[0].offsetWidth + 24;
        const currentPage = Math.round(carousel.scrollLeft / (cardWidth * itemsPerPage));
        setActiveDot(currentPage);
    });
});
</script>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold gradient-text mb-4">Hubungi Kami</h2>
                <p class="text-xl text-gray-600">Kami siap membantu Anda!</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg mb-6">
                        <h3 class="text-2xl font-bold text-[#184E83] mb-6">Informasi Kontak</h3>
                        
                        <!-- Address -->
                        <div class="flex items-start mb-6">
                            <div class="w-12 h-12 bg-[#FFBF00] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#184E83] mb-1">Alamat</h4>
                                <p class="text-gray-600">Jl. Lilium Sel. II No.1, Sidomukti, Kraton, Kec. Krian<br>Kabupaten Sidoarjo, Jawa Timur 61262</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start mb-6">
                            <div class="w-12 h-12 bg-[#FFBF00] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#184E83] mb-1">Telepon</h4>
                                <p class="text-gray-600">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start mb-6">
                            <div class="w-12 h-12 bg-[#FFBF00] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#184E83] mb-1">Email</h4>
                                <p class="text-gray-600"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="e1888f878ea189808a948f808c8095809580828e94939284cf828e8c">[email&#160;protected]</a></p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-[#FFBF00] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#184E83] mb-1">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Sabtu: 08.00 - 20.00<br>Minggu: 09.00 - 17.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div>
                    <div class="bg-white p-4 rounded-2xl shadow-lg h-full">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3080.7338798034584!2d112.57182757367772!3d-7.406684592603425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7809d44792e67b%3A0xc278292beb9f8cd1!2sHakuna%20Matata%20Course!5e1!3m2!1sid!2sid!4v1767602741397!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0; border-radius: 1rem; min-height: 450px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 wave-pattern">
        <div class="max-w-4xl mx-auto px-6 text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Siap Meraih Prestasi Terbaik?</h2>
            <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan siswa yang telah sukses bersama kami!</p>
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSenK5uHuv3jRGelG_nRNuO1TOXGkzIC2Z-lz0kdzDZjG2MR1g/viewform?pli=1" target="_blank" class="btn-primary inline-block px-12 py-4 text-[#184E83] font-bold rounded-full transition transform text-lg">
                Daftar Sekarang Gratis!
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0F3A5F] text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-[#FFBF00]">Hakuna Matata Course</h3>
                    <p class="text-blue-200">Bimbingan belajar terpercaya untuk mencapai prestasi terbaik.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-[#FFBF00]">Menu</h3>
                    <ul class="space-y-2 text-blue-200">
                        <li><a href="#beranda" class="hover:text-[#FFBF00] transition">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-[#FFBF00] transition">Tentang</a></li>
                        <li><a href="#tentor" class="hover:text-[#FFBF00] transition">Tentor</a></li>
                        <li><a href="#kontak" class="hover:text-[#FFBF00] transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Programs -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-[#FFBF00]">Program</h3>
                    <ul class="space-y-2 text-blue-200">
                        <li>Bimbel SD</li>
                        <li>Bimbel SMP</li>
                        <li>Bimbel SMA</li>
                        <li>Persiapan SBMPTN</li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-[#FFBF00]">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-[#FFBF00] rounded-full flex items-center justify-center hover:bg-[#FFD700] transition">
                            <svg class="w-5 h-5 text-[#184E83]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#FFBF00] rounded-full flex items-center justify-center hover:bg-[#FFD700] transition">
                            <svg class="w-5 h-5 text-[#184E83]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#FFBF00] rounded-full flex items-center justify-center hover:bg-[#FFD700] transition">
                            <svg class="w-5 h-5 text-[#184E83]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-blue-800 pt-8 text-center text-blue-200">
                <p>&copy; 2025 Hakuna Matata Course. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = doc