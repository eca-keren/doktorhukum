<header class="w-full shadow-sm" x-data="{ openMenu: null }">

    <!-- TOP BAR -->
    <div class="w-full bg-gradient-to-r from-[#80A7E0] to-[#5A8BD6] py-4">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo_unib.png') }}"
                     class="h-16 w-auto"
                     alt="Logo Universitas Bengkulu">

                <div class="leading-tight">
                    <h1 class="text-2xl font-bold text-white">DOKTOR HUKUM</h1>
                    <p class="text-white text-sm">Universitas Bengkulu</p>
                </div>
            </div>

            <!-- SEARCH BAR -->
            <div class="relative hidden md:block">
                <input type="text"
                       placeholder="Search..."
                       class="w-96 rounded-full py-3 pl-6 pr-12 bg-white shadow-md outline-none focus:ring-2 focus:ring-blue-400 text-gray-700">

                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-700">
                    <i class="bi bi-search text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- MENU BAR -->
    <nav class="bg-[#4A76C0] w-full">
        <div class="max-w-7xl mx-auto px-4">
            <ul class="flex items-center gap-8 text-white font-medium text-sm h-12 justify-end">

                <!-- HOME -->
                <li>
                    <a href="/" class="px-4 py-2 rounded-full bg-white text-[#4A76C0] font-semibold">
                        Home
                    </a>
                </li>

                <!-- MENU TEMPLATE -->
                @php
                    $menus = [
                        "profil" => [
                            ["Sejarah", "#"],
                            ["Visi & Misi", "#"],
                            ["Tujuan & Strategi", "#"],
                            ["Struktur Organisasi", "#"],
                            ["Dosen", "#"]
                        ],
                        "akademik" => [
                            ["Kurikulum", "#"],
                            ["Kalender Akademik", "#"],
                            ["Tahapan Studi", "#"]
                        ],
                        "ppm" => [
                            ["Penelitian", "#"],
                            ["Pengabdian", "#"]
                        ],
                        "registrasi" => [
                            ["Pendaftaran", "#"],
                            ["MABA", "#"],
                            ["Alumni", "#"]
                        ],
                        "info" => [
                            ["Pusat Informasi", "#"],
                            ["SATGAS PPKT", "#"],
                            ["Kontak", "#"]
                        ]
                    ];
                @endphp

                <!-- GENERATE MENU DROPDOWN -->
                @foreach ($menus as $key => $items)
                <li class="relative"
                    @click.away="openMenu = null">

                    <button
@click.stop="openMenu = (openMenu === '{{ $key }}' ? null : '{{ $key }}')"
                        class="hover:text-blue-200">
                        {{ ucfirst($key) }}
                    </button>

                    <div
                        x-show="openMenu === '{{ $key }}'"
                        x-transition
                        class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56 z-50">

                        @foreach ($items as $item)
                            <a class="block px-4 py-2 hover:bg-gray-100" href="{{ $item[1] }}">
                                {{ $item[0] }}
                            </a>
                        @endforeach
                    </div>
                </li>
                @endforeach

                <!-- LANGUAGE SWITCH -->
                <li class="relative" @click.away="openMenu=null">
                    <button @click="openMenu = (openMenu === 'lang' ? null : 'lang')"
                            class="flex items-center gap-2">
                        🇮🇩 <span class="text-white">ID</span>
                    </button>

                    <div
                        x-show="openMenu === 'lang'"
                        x-transition
                        class="absolute right-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-36 z-50">

                        <button class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 w-full text-left">
                            🇬🇧 <span>English</span>
                        </button>
                    </div>
                </li>

            </ul>
        </div>
    </nav>

</header>
