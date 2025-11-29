<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-white dark:bg-neutral-950">
        <!-- Header Navigation -->
        @include('partials.header')

        <!-- Hero Section -->
        <section class="relative min-h-[90vh] bg-gradient-to-b from-blue-50 to-white dark:from-neutral-900 dark:to-neutral-950 overflow-hidden">
            <div class="absolute inset-0 opacity-90 dark:opacity-60"
                 style="background-image: url('{{ asset('images/gambarunib5.jpg') }}'); background-size: cover; background-position: center;">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-blue-900/20 to-blue-900/50 dark:from-blue-900/40 dark:to-blue-900/60"></div>
            
            <div class="relative z-10 flex items-end min-h-[90vh] px-4 sm:px-6 lg:px-8">
                <div class="w-full max-w-4xl pb-12 sm:pb-16 lg:pb-20">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight leading-tight">
                        SELAMAT DATANG
                    </h1>
                    <p class="text-lg sm:text-xl text-blue-50 mb-8 max-w-2xl leading-relaxed">
                        DI PROGRAM DOKTOR HUKUM, PROGRAM STUDI HUKUM, FAKULTAS HUKUM, UNIVERSITAS BENGKULU
                    </p>
                    <flux:button href="#" variant="primary" class="px-8 py-3 text-base font-bold">
                        Eksplor Program
                    </flux:button>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="py-16 sm:py-20 lg:py-24 bg-blue-50 dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <!-- Image -->
                    <div class="flex justify-center fade-in-scroll">
                        <img src="{{ asset('images/ProfHerlambang.png') }}" 
                             alt="Prof. Dr. Herlambang S.H., M.H." 
                             class="max-w-sm w-full h-auto rounded-lg shadow-lg">
                    </div>

                    <!-- Content -->
                    <div class="space-y-8">
                        <div class="fade-in-scroll">
                            <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                                VISI DAN MISI
                            </h2>
                            <p class="text-lg text-blue-600 dark:text-blue-400 font-semibold">
                                DOKTOR HUKUM UNIVERSITAS BENGKULU
                            </p>
                        </div>

                        <!-- Vision -->
                        <div class="fade-in-scroll space-y-3">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white">VISI</h3>
                            <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed text-lg">
                                Mewujudkan Doktor Hukum yang unggul dalam penelitian dan pengabdian berbasis kearifan lokal dan global.
                            </p>
                        </div>

                        <!-- Mission -->
                        <div class="fade-in-scroll space-y-4">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white">MISI</h3>
                            <ul class="space-y-3">
                                <li class="flex gap-3 items-start">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mt-1">✓</span>
                                    <span class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                                        Menyelenggarakan pendidikan doktor hukum yang berkualitas dan berdaya saing nasional-internasional.
                                    </span>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mt-1">✓</span>
                                    <span class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                                        Mengembangkan penelitian hukum yang inovatif dan relevan dengan kebutuhan masyarakat.
                                    </span>
                                </li>
                                <li class="flex gap-3 items-start">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold mt-1">✓</span>
                                    <span class="text-neutral-700 dark:text-neutral-300 leading-relaxed">
                                        Mendorong pengabdian kepada masyarakat berbasis hukum yang berkeadilan dan inklusif.
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- Profile -->
                        <div class="fade-in-scroll pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <p class="text-lg font-bold text-neutral-900 dark:text-white">
                                PROF. DR. HERLAMBANG S.H., M.H.
                            </p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 font-medium mt-1">
                                KETUA PROGRAM STUDI DOKTOR HUKUM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Acceptance Information Section -->
        <section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-neutral-950">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full border-2 border-neutral-900 dark:border-white mb-6">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-white">i</span>
                </div>

                <h3 class="text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white mb-4">
                    INFO PENERIMAAN
                </h3>

                <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8 max-w-2xl mx-auto">
                    Silakan cek secara berkala terkait penerimaan mahasiswa baru program doktor
                </p>

                <flux:button href="#" variant="primary" class="px-8 py-3 text-base font-bold">
                    Tekan Disini
                </flux:button>
            </div>
        </section>

        <!-- Footer -->
        @include('partials.footer')

        <style>
            /* Scroll Animation */
            .fade-in-scroll {
                opacity: 0;
                transform: translateY(2rem);
                transition: all 0.9s ease;
            }

            .fade-in-scroll.visible {
                opacity: 1 !important;
                transform: translateY(0);
            }

            /* Hover Effects */
            .fade-in-scroll:hover {
                transform: translateY(-0.25rem);
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.15 });

                const elements = document.querySelectorAll('.fade-in-scroll');
                elements.forEach(el => {
                    observer.observe(el);
                });
            });
        </script>
    </body>
</html>
