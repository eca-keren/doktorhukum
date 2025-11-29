<header class="w-full shadow-sm">
    
    <!-- TOP BAR -->
    <div class="w-full bg-gradient-to-r from-[#80A7E0] to-[#5A8BD6] py-4">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">

            <!-- LEFT SIDE (LOGO + TEXT) -->
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
            <ul class="flex items-center gap-8 text-white font-medium text-sm h-12">

                <!-- HOME -->
                <li>
                    <a href="/" class="px-4 py-2 rounded-full bg-white text-[#4A76C0] font-semibold">
                        Home
                    </a>
                </li>

                <!-- PROFIL -->
                <li x-data="{open:false}" class="relative">
                    <button @mouseover="open=true" @mouseleave="open=false"
                            class="hover:text-blue-200">
                        Profil
                    </button>

                    <div x-show="open"
                         @mouseover="open=true"
                         @mouseleave="open=false"
                         class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56">

                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Sejarah</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Visi & Misi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Tujuan & Strategi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Struktur Organisasi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Dosen</a>
                    </div>
                </li>

                <!-- AKADEMIK -->
                <li x-data="{open:false}" class="relative">
                    <button @mouseover="open=true" @mouseleave="open=false"
                            class="hover:text-blue-200">
                        Akademik
                    </button>

                    <div x-show="open"
                         @mouseover="open=true"
                         @mouseleave="open=false"
                         class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56">
                        
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Kurikulum</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Kalender Akademik</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Tahapan Studi</a>
                    </div>
                </li>

                <!-- PPM & UPM -->
                <li x-data="{open:false}" class="relative">
                    <button @mouseover="open=true" @mouseleave="open=false"
                            class="hover:text-blue-200">
                        PPM & UPM
                    </button>

                    <div x-show="open"
                         @mouseover="open=true"
                         @mouseleave="open=false"
                         class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56">
                        
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Penelitian</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Pengabdian</a>
                    </div>
                </li>

                <!-- REGISTRASI -->
                <li x-data="{open:false}" class="relative">
                    <button @mouseover="open=true" @mouseleave="open=false"
                            class="hover:text-blue-200">
                        Registrasi
                    </button>

                    <div x-show="open"
                         @mouseover="open=true"
                         @mouseleave="open=false"
                         class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56">
                        
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Pendaftaran</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">MABA</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Alumni</a>
                    </div>
                </li>

                <!-- INFO -->
                <li x-data="{open:false}" class="relative">
                    <button @mouseover="open=true" @mouseleave="open=false"
                            class="hover:text-blue-200">
                        Info
                    </button>

                    <div x-show="open"
                         @mouseover="open=true"
                         @mouseleave="open=false"
                         class="absolute left-0 top-12 bg-white text-gray-900 rounded-lg shadow-lg py-3 w-56">
                        
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Pusat Informasi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">SATGAS PPKT</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="#">Kontak</a>
                    </div>
                </li>

            </ul>
        </div>
    </nav>

</header>
