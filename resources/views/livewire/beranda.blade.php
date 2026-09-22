<div class="relative w-full h-full flex flex-col items-center justify-center p-4 overflow-hidden">

    <style>
        /* ============================================================
           PENGATURAN ANIMASI (Karakter, Pohon & Kapal)
           ============================================================ */
        @keyframes charSlideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-140px) translateY(50px) scale(0.9);
            }
            70% {
                opacity: 1;
                transform: translateX(12px) translateY(-5px) scale(1.02);
            }
            100% {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
            }
        }

        @keyframes charIdleFloat {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-6px) rotate(-0.8deg);
            }
        }

        /* Animasi goyang pohon pelan */
        @keyframes treeSway {
            0%, 100% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(1.8deg);
            }
        }

        /* Animasi kapal berlayar menembus dari luar frame kanan ke kiri */
        @keyframes shipSailRightToLeft {
            0% {
                transform: translateX(100vw);
            }
            100% {
                transform: translateX(-450px);
            }
        }

        /* Animasi ombak kapal (naik-turun & miring halus) */
        @keyframes shipBobbing {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-6px) rotate(-1.5deg);
            }
        }

        .animate-char-entrance-left {
            opacity: 0;
            animation: charSlideInLeft 0.9s cubic-bezier(0.25, 1, 0.5, 1) 0.3s forwards;
        }

        .animate-char-idle {
            animation: charIdleFloat 3.5s ease-in-out infinite;
        }

        .animate-tree-sway {
            transform-origin: top center;
            animation: treeSway 6s ease-in-out infinite;
        }

        .animate-ship-sail {
            position: absolute;
            left: 0;
            will-change: transform;
            /* 26s = waktu kapal menyeberangi layar. Semakin kecil angkanya, semakin cepat kapalnya berlayar */
            animation: shipSailRightToLeft 38s linear infinite;
        }

        .animate-ship-bob {
            animation: shipBobbing 3.2s ease-in-out infinite;
        }
    </style>

    <!-- ============================================================
         KAPAL LAUT (BERLAYAR DARI KANAN KE KIRI SECARA TERUS MENERUS)
         ============================================================ -->
    <div class="animate-ship-sail z-5 pointer-events-none" style="top: 34%;">
        <div class="animate-ship-bob">
            <img src="{{ asset('assets/kapal.webp') }}" 
                 alt="Kapal Laut" 
                 class="w-[95px] sm:w-[140px] md:w-[200px] lg:w-[260px] h-auto drop-shadow-md select-none pointer-events-none">
        </div>
    </div>

    <!-- ============================================================
         1. DEKORASI POHON KIRI
         ============================================================ -->
    <div class="absolute z-10 pointer-events-none -top-4 sm:-top-8 md:-top-10 -left-24 sm:-left-36 md:-left-48">
        <div class="animate-tree-sway">
            <img src="{{ asset('assets/pohon.webp') }}" 
                 alt="Pohon Kiri" 
                 class="h-[58vh] sm:h-[75vh] md:h-[88vh] w-auto drop-shadow-md select-none opacity-85 sm:opacity-100 pointer-events-none">
        </div>
    </div>

    <!-- ============================================================
         2. DEKORASI POHON KANAN (MIRRORED)
         ============================================================ -->
    <div class="absolute z-10 pointer-events-none -top-4 sm:-top-8 md:-top-10 -right-24 sm:-right-36 md:-right-48 scale-x-[-1]">
        <div class="animate-tree-sway" style="animation-delay: -3s;">
            <img src="{{ asset('assets/pohon.webp') }}" 
                 alt="Pohon Kanan (Mirrored)" 
                 class="h-[58vh] sm:h-[75vh] md:h-[88vh] w-auto drop-shadow-md select-none opacity-85 sm:opacity-100 pointer-events-none">
        </div>
    </div>

    <!-- ============================================================
         3. KARAKTER DI SISI KIRI BAWAH (c_menyapa)
         ============================================================ -->
    <div class="absolute z-20 pointer-events-none animate-char-entrance-left -bottom-8 sm:-bottom-14 md:-bottom-20 -left-2 sm:left-2 md:left-6">
        <div class="animate-char-idle">
            <img src="{{ asset('assets/c_menyapa.webp') }}" 
                 alt="Karakter Menyapa" 
                 class="h-[46vh] sm:h-[58vh] md:h-[68vh] w-auto drop-shadow-[0_12px_15px_rgba(0,0,0,0.25)] select-none pointer-events-none">
        </div>
    </div>

    <!-- ============================================================
         4. KONTEN TENGAH: LOGO BESAR & TOMBOL MULAI
         ============================================================ -->
    <div class="z-30 flex flex-col items-center justify-center text-center gap-1.5 sm:gap-3 md:gap-4 max-w-2xl px-3 sm:px-4 my-auto">
        
        <!-- Logo SABI -->
        <img src="{{ asset('assets/sabi.webp') }}" 
             alt="SABI" 
             class="w-[190px] sm:w-[280px] md:w-[420px] lg:w-[500px] max-h-[38vh] h-auto object-contain drop-shadow-xl transition-transform hover:scale-105 duration-300 select-none pointer-events-none">

        <!-- Tombol Mulai -->
        @auth
            <a href="{{ route('menu') }}" data-sfx="hover" class="block transition-transform hover:scale-105 active:scale-95 mt-0.5 sm:mt-1 cursor-pointer">
                <img src="{{ asset('assets/mulai.webp') }}" alt="Mulai" class="w-28 sm:w-36 md:w-48 max-h-[16vh] h-auto object-contain drop-shadow-lg select-none pointer-events-none">
            </a>
        @else
            <button type="button" onclick="openNameModal()" data-sfx="hover" class="block transition-transform hover:scale-105 active:scale-95 mt-0.5 sm:mt-1 cursor-pointer focus:outline-none border-none bg-transparent p-0">
                <img src="{{ asset('assets/mulai.webp') }}" alt="Mulai" class="w-28 sm:w-36 md:w-48 max-h-[16vh] h-auto object-contain drop-shadow-lg select-none pointer-events-none">
            </button>
        @endauth
    </div>

    <!-- ============================================================
         5. POP UP MODAL MASUKKAN NAMA (Siapa Namamu? - TEMA PAPAN KAYU)
         ============================================================ -->
    <div id="nameModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 font-['Jua']">
        
        <!-- Backdrop clickable to close -->
        <div class="absolute inset-0" onclick="closeNameModal()"></div>

        <!-- Modal Box: Papan Kayu -->
        <div id="modalBox" 
             class="relative z-10 w-full max-w-[420px] transform scale-90 transition-all duration-300 rounded-3xl border-4 border-[#3D1804] px-6 py-6 shadow-[0_20px_40px_rgba(0,0,0,0.5),0_8px_0_#280E02,inset_0_2px_0_rgba(255,255,255,0.25),inset_0_-3px_0_rgba(0,0,0,0.35)]"
             style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
            
            <!-- 4 Baut / Paku di Setiap Sudut Papan Kayu -->
            <div class="absolute top-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
            <div class="absolute top-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
            <div class="absolute bottom-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
            <div class="absolute bottom-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>

            <!-- Tombol Tutup (X) -->
            <button type="button" 
                    onclick="closeNameModal()" 
                    class="absolute -top-3.5 -right-3.5 w-10 h-10 rounded-full bg-gradient-to-b from-[#EF4444] to-[#B91C1C] hover:from-[#F87171] hover:to-[#DC2626] text-white font-bold text-lg flex items-center justify-center border-2 border-white shadow-[0_4px_8px_rgba(0,0,0,0.3)] transition-transform hover:scale-110 active:scale-95 cursor-pointer z-20">
                ✕
            </button>

            <!-- Header Modal Papan Kayu -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/sabi.webp') }}" alt="SABI Logo" class="w-20 md:w-24 h-auto mx-auto mb-1 drop-shadow-md">
                <h2 class="text-2xl md:text-3xl font-bold text-[#FFF2A6] tracking-wide" 
                    style="text-shadow: 2px 2px 0 #3D1804, -2px -2px 0 #3D1804, 2px -2px 0 #3D1804, -2px 2px 0 #3D1804, 0 4px 6px rgba(0,0,0,0.4);">
                    Siapa Namamu?
                </h2>
                <p class="text-xs text-[#FFE8A3] font-medium mt-0.5">
                    Tuliskan namamu untuk memulai petualangan!
                </p>
            </div>

            <!-- Bagian Dalam: Kartu Papan / Kertas Perkamen -->
            <div class="rounded-2xl border-3 border-[#612A07] bg-gradient-to-b from-[#FFFDF0] to-[#FCEEC7] p-4 md:p-5 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)]">
                <form method="POST" action="{{ route('login') }}" class="w-full">
                    @csrf
                    <!-- Default avatar (1 karakter saja) -->
                    <input type="hidden" name="avatar" value="co">

                    <div class="space-y-3">
                        <!-- Input Nama -->
                        <div>
                            <label class="block text-xs md:text-sm font-bold text-[#6D360B] mb-1.5 text-left" for="modal_name">
                                Nama Panggilan / Lengkap Kamu
                            </label>
                            <input id="modal_name" 
                                   name="name" 
                                   type="text" 
                                   placeholder="Ketik namamu di sini..." 
                                   required 
                                   autocomplete="off"
                                   class="w-full h-12 rounded-xl bg-white border-2 border-[#A85D25] px-4 text-amber-950 text-base md:text-lg font-semibold outline-none focus:ring-4 focus:ring-[#E68A2E]/35 focus:border-[#7A3408] placeholder:font-normal placeholder:text-amber-800/40 shadow-inner font-['Jua']">
                        </div>

                        <!-- Tombol Submit -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full rounded-full border-3 border-white/90 bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] py-3 text-white font-bold text-lg md:text-xl tracking-wide shadow-[0_6px_0_#0F5128,0_10px_15px_rgba(0,0,0,0.2)] hover:brightness-110 active:translate-y-[2px] active:shadow-[0_2px_0_#0F5128] transition-all cursor-pointer font-['Jua']">
                                Mulai Belajar! ⛵
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Kontrol Pop Up Modal -->
    <script>
        function openNameModal() {
            const modal = document.getElementById('nameModal');
            const modalBox = document.getElementById('modalBox');
            const nameInput = document.getElementById('modal_name');

            if (modal && modalBox) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                
                modalBox.classList.remove('scale-90');
                modalBox.classList.add('scale-100');

                setTimeout(() => {
                    if (nameInput) nameInput.focus();
                }, 150);
            }
        }

        function closeNameModal() {
            const modal = document.getElementById('nameModal');
            const modalBox = document.getElementById('modalBox');

            if (modal && modalBox) {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-90');
            }
        }

        // Tutup modal jika tombol Escape ditekan
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNameModal();
            }
        });
    </script>
