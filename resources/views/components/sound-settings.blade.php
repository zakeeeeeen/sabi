<!-- ============================================================
     TOMBOL PENGATURAN SUARA (POJOK KANAN ATAS)
     ============================================================ -->
<div class="absolute top-3 right-3 sm:top-4 sm:right-5 md:top-5 md:right-6 z-40">
    <button type="button" 
            onclick="openSettingsModal()" 
            data-sfx="hover" 
            class="transition-transform hover:scale-110 active:scale-95 cursor-pointer block border-none bg-transparent p-0 focus:outline-none"
            title="Pengaturan Suara">
        <img src="{{ asset('assets/pengaturan_button.webp') }}" 
             alt="Pengaturan Suara" 
             class="w-10 sm:w-12 md:w-14 lg:w-16 h-auto drop-shadow-md select-none pointer-events-none">
    </button>
</div>

<!-- ============================================================
     POP-UP MODAL PENGATURAN SUARA (THEME PAPAN KAYU - VECTOR ICONS)
     ============================================================ -->
<div id="settingsModal" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 font-['Jua'] select-none">
    
    <!-- Backdrop -->
    <div class="absolute inset-0" onclick="closeSettingsModal()"></div>

    <!-- Modal Box Papan Kayu -->
    <div id="settingsBox" 
         class="relative z-10 w-full max-w-[420px] transform scale-90 transition-all duration-300 rounded-3xl border-4 border-[#3D1804] px-6 py-6 shadow-[0_20px_40px_rgba(0,0,0,0.5),0_8px_0_#280E02,inset_0_2px_0_rgba(255,255,255,0.25),inset_0_-3px_0_rgba(0,0,0,0.35)]"
         style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
        
        <!-- Baut Sudut -->
        <div class="absolute top-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
        <div class="absolute top-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
        <div class="absolute bottom-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
        <div class="absolute bottom-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>

        <!-- Tombol Tutup (X) -->
        <button type="button" 
                onclick="closeSettingsModal()" 
                class="absolute -top-3.5 -right-3.5 w-10 h-10 rounded-full bg-gradient-to-b from-[#EF4444] to-[#B91C1C] hover:from-[#F87171] hover:to-[#DC2626] text-white font-bold text-lg flex items-center justify-center border-2 border-white shadow-[0_4px_8px_rgba(0,0,0,0.3)] transition-transform hover:scale-110 active:scale-95 cursor-pointer z-20">
            ✕
        </button>

        <!-- Header Modal -->
        <div class="text-center mb-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#FFF2A6] tracking-wide" 
                style="text-shadow: 2px 2px 0 #3D1804, -2px -2px 0 #3D1804, 2px -2px 0 #3D1804, -2px 2px 0 #3D1804, 0 4px 6px rgba(0,0,0,0.4);">
                Pengaturan Suara
            </h2>
            <p class="text-xs text-[#FFE8A3] font-medium mt-0.5">
                Atur volume musik latar belakang
            </p>
        </div>

        <!-- Kartu Perkamen Dalam -->
        <div class="rounded-2xl border-3 border-[#612A07] bg-gradient-to-b from-[#FFFDF0] to-[#FCEEC7] p-4 sm:p-5 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] space-y-4">
            
            <!-- 1. Kontrol Musik Latar (BGM) -->
            <div class="bg-white/90 border-2 border-[#D49B5B] rounded-xl p-3.5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center text-[#B45309] shrink-0 border border-amber-200">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-[#6D360B]">Musik Latar</span>
                    </div>
                    <span id="bgmVolumeVal" class="text-sm sm:text-base font-bold text-[#2D7BFF] bg-sky-50 px-2.5 py-0.5 rounded-lg border border-sky-200 shadow-inner">
                        60%
                    </span>
                </div>

                <!-- Slider Volume -->
                <div class="py-1">
                    <input id="bgmVolumeSlider" type="range" min="0" max="100" value="60" class="w-full cursor-pointer accent-[#00A3FF]">
                </div>

                <!-- Tombol Mute / Suara -->
                <div class="mt-2.5 flex justify-end">
                    <button id="bgmMuteBtn" type="button" class="px-4 py-1.5 rounded-xl bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-bold flex items-center gap-1.5 shadow transition-all active:scale-95 cursor-pointer">
                        <span id="bgmMuteIcon" class="flex items-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3">
                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                            </svg>
                        </span>
                        <span id="bgmMuteLabel">Aktif</span>
                    </button>
                </div>
            </div>

            <!-- Tombol Simpan & Tutup -->
            <div class="pt-1">
                <button type="button" 
                        onclick="closeSettingsModal()" 
                        class="w-full rounded-full border-3 border-white/90 bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] py-2.5 text-white font-bold text-base sm:text-lg tracking-wide shadow-[0_5px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] active:shadow-[0_2px_0_#0F5128] transition-all flex items-center justify-center gap-2 cursor-pointer font-['Jua']">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Simpan & Selesai</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    window.__SABI_BGM_URL = "{{ asset('assets/underthesea.mp3') }}";

    window.openSettingsModal = function() {
        var modal = document.getElementById('settingsModal');
        var box = document.getElementById('settingsBox');
        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none', 'hidden');
            modal.classList.add('opacity-100', 'pointer-events-auto', 'flex');
            if (box) {
                box.classList.remove('scale-90');
                box.classList.add('scale-100');
            }
        }
        if (window.sabiBgm) {
            window.sabiBgm.updateModalUI();
        } else {
            // Standalone sync if global instance not ready
            try {
                var slider = document.getElementById('bgmVolumeSlider');
                var valText = document.getElementById('bgmVolumeVal');
                var savedVol = localStorage.getItem('sabi_bgm_volume') || '60';
                if (slider) slider.value = savedVol;
                if (valText) valText.textContent = savedVol + '%';
            } catch(e) {}
        }
    };

    window.closeSettingsModal = function() {
        var modal = document.getElementById('settingsModal');
        var box = document.getElementById('settingsBox');
        if (modal) {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            if (box) {
                box.classList.remove('scale-100');
                box.classList.add('scale-90');
            }
        }
    };
</script>
