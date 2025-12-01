<div class="py-16 sm:py-20 bg-white dark:bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- GRID BERITA (kiri) + PENGUMUMAN (kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12"> <!-- gap diperbesar -->

            <!-- ================= BERITA ================= -->
            <div class="lg:col-span-2 space-y-8"> <!-- jarak antar bagian dibesarkan -->
                
                <h2 class="text-2xl font-bold text-[#2E2A5B]">BERITA UTAMA</h2>

                @if ($latestNews->isNotEmpty())
                    
                    <!-- ======= BERITA BESAR (ATAS) ======= -->
                    <article class="rounded-xl overflow-hidden border border-neutral-300 dark:border-neutral-700 bg-[#F4F6FF] dark:bg-neutral-900 shadow-md">
                        <img
                            src="{{ Storage::url($latestNews[0]->image) }}"
                            alt="{{ $latestNews[0]->title }}"
                            class="w-full h-64 object-cover"
                        />
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">
                                {{ $latestNews[0]->title }}
                            </h3>

                            <p class="text-sm text-neutral-700 dark:text-neutral-400 mb-3">
                                {{ Str::limit($latestNews[0]->description, 120) }}
                            </p>

                            <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-4">
                                {{ $latestNews[0]->date->format('F j, Y') }}
                            </div>

                            <a href="#"
                               class="inline-flex items-center px-5 py-2 bg-[#3D386B] text-white text-sm rounded-full hover:bg-[#2E2A5B] transition">
                                LIHAT
                            </a>
                        </div>
                    </article>

<!-- ======= DUA BERITA KECIL ======= -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    @for ($i = 1; $i < min(3, $latestNews->count()); $i++)
        <article class="rounded-xl overflow-hidden border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 shadow">
            <img
                src="{{ Storage::url($latestNews[$i]->image) }}"
                class="w-full h-36 object-cover"
                alt="{{ $latestNews[$i]->title }}"
            />
            <div class="p-4">
                <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-2">
                    {{ $latestNews[$i]->title }}
                </h3>

                <!-- Tambahkan DESKRIPSI singkat -->
                <p class="text-xs text-neutral-600 dark:text-neutral-400 mb-2">
                    {{ Str::limit($latestNews[$i]->description, 60) }}
                </p>

                <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">
                    {{ $latestNews[$i]->date->format('F j, Y') }}
                </div>

                <a href="#"
                   class="inline-flex items-center px-4 py-2 bg-[#3D386B] text-white text-xs rounded-full hover:bg-[#2E2A5B] transition">
                    LIHAT
                </a>
            </div>
        </article>
    @endfor
</div>

                @else
                    <div class="text-center py-12 text-neutral-500 dark:text-neutral-400">
                        Belum ada berita.
                    </div>
                @endif
            </div>

            <!-- ================= PENGUMUMAN ================= -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-300 dark:border-neutral-700 p-6 shadow-md h-fit">

                <div class="bg-[#FFB300] rounded-full py-3 px-6 mb-6">
                    <h2 class="text-xl font-bold text-[#2E2A5B] text-center">PENGUMUMAN</h2>
                </div>

                <div class="space-y-6">
                    @foreach ($latestAnnouncements as $a)
                        <div class="pb-4 border-b border-neutral-300 dark:border-neutral-700">
                            <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">
                                {{ $a->title }}
                            </h3>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">
                                {{ $a->date->format('F j, Y') }}
                            </div>

                            <a href="#"
                               class="inline-flex items-center px-4 py-2 bg-[#3D386B] text-white text-sm rounded-full hover:bg-[#2E2A5B] transition">
                                LIHAT
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
