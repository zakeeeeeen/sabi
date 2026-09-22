<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Bisnisku - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Jua&display=swap" rel="stylesheet">

        <script>
            try {
                if (sessionStorage.getItem('app.booted') === '1') {
                    document.documentElement.classList.add('app-booted');
                }
            } catch {
            }
        </script>
        <style>
            
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Paytone_One']">
        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                
                <!-- Header Title -->
                <div class="absolute left-0 right-0 top-3 md:top-6 flex justify-center px-4 z-20">
                    <div class="rounded-[24px] bg-[#D9D9D9]/80 px-8 md:px-14 py-2 md:py-3 border border-black/10 shadow-[0_8px_0_rgba(0,0,0,0.15)]">
                        <div class="text-[#00A3FF] text-2xl md:text-5xl leading-none tracking-wide text-center"
                            style="text-shadow: -2px 0 #ffffff, 2px 0 #ffffff, 0 -2px #ffffff, 0 2px #ffffff, 0 5px 0 rgba(0,0,0,0.15);">
                            BISNISKU
                        </div>
                    </div>
                </div>

                <!-- Top Right Logo -->
                <div class="absolute top-3 right-3 md:top-5 md:right-6 z-20">
                    <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-24 md:w-36 h-auto drop-shadow">
                </div>

                <!-- Top Left Subtitle -->
                <div class="absolute top-4 left-4 md:top-6 md:left-6 z-20 hidden sm:flex items-center gap-2 bg-white/85 px-4 py-1.5 rounded-full border border-black/10 shadow">
                    <span class="text-xs md:text-sm text-slate-800 font-['Plus_Jakarta_Sans'] font-bold">🚀 Pilih Bagian Pembelajaran:</span>
                </div>

                <!-- Main Content: 3 Sections Grid -->
                <div class="absolute inset-x-0 top-[18%] md:top-[22%] bottom-20 md:bottom-24 flex items-center justify-center px-4 md:px-12 overflow-y-auto">
                    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 py-2">
                        
                        <!-- Bagian 1 Card -->
                        <div class="flex flex-col justify-between rounded-3xl bg-gradient-to-b from-[#FFF9D2] to-[#FFF099] border-4 border-white p-4 md:p-6 shadow-[0_10px_0_rgba(0,0,0,0.12)] hover:-translate-y-1 transition-all duration-200">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-3 py-1 rounded-full bg-[#FFA24A] text-white text-xs font-['Plus_Jakarta_Sans'] font-extrabold uppercase tracking-wider shadow-sm">
                                        Bagian 1
                                    </span>
                                    <span class="text-2xl md:text-3xl">💰</span>
                                </div>

                                <h2 class="text-lg md:text-xl text-[#0077B6] leading-tight mb-2">
                                    Mendapatkan Uang
                                </h2>

                                <p class="text-xs md:text-sm text-slate-700 font-['Plus_Jakarta_Sans'] leading-relaxed font-medium mb-4">
                                    Hubungkan bisnismu dengan cara menghasilkan produk/jasa yang bernilai sehingga mendatangkan penghasilan dari pembeli.
                                </p>
                            </div>

                            <button type="button" onclick="openSectionModal(1)" data-sfx="hover"
                                class="w-full rounded-2xl bg-gradient-to-b from-[#00A3FF] to-[#0077B6] py-2.5 px-4 text-white text-xs md:text-sm tracking-wide shadow-[0_4px_0_rgba(0,0,0,0.15)] hover:brightness-110 active:translate-y-[2px] active:shadow-none transition-all">
                                Buka Bagian 1 ✨
                            </button>
                        </div>

                        <!-- Bagian 2 Card -->
                        <div class="flex flex-col justify-between rounded-3xl bg-gradient-to-b from-[#E3F2FD] to-[#BBDEFB] border-4 border-white p-4 md:p-6 shadow-[0_10px_0_rgba(0,0,0,0.12)] hover:-translate-y-1 transition-all duration-200">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-3 py-1 rounded-full bg-[#2D7BFF] text-white text-xs font-['Plus_Jakarta_Sans'] font-extrabold uppercase tracking-wider shadow-sm">
                                        Bagian 2
                                    </span>
                                    <span class="text-2xl md:text-3xl">📊</span>
                                </div>

                                <h2 class="text-lg md:text-xl text-[#1E3A8A] leading-tight mb-2">
                                    Rencana Pengeluaran & Tabungan
                                </h2>

                                <p class="text-xs md:text-sm text-slate-700 font-['Plus_Jakarta_Sans'] leading-relaxed font-medium mb-4">
                                    Analisis rencana pengeluaran bisnismu secara bijak dan pentingnya memiliki tabungan untuk keadaan darurat di masa depan.
                                </p>
                            </div>

                            <button type="button" onclick="openSectionModal(2)" data-sfx="hover"
                                class="w-full rounded-2xl bg-gradient-to-b from-[#2D7BFF] to-[#1E3A8A] py-2.5 px-4 text-white text-xs md:text-sm tracking-wide shadow-[0_4px_0_rgba(0,0,0,0.15)] hover:brightness-110 active:translate-y-[2px] active:shadow-none transition-all">
                                Buka Bagian 2 📝
                            </button>
                        </div>

                        <!-- Bagian 3 Card -->
                        <div class="flex flex-col justify-between rounded-3xl bg-gradient-to-b from-[#E8F5E9] to-[#C8E6C9] border-4 border-white p-4 md:p-6 shadow-[0_10px_0_rgba(0,0,0,0.12)] hover:-translate-y-1 transition-all duration-200">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-3 py-1 rounded-full bg-[#43A047] text-white text-xs font-['Plus_Jakarta_Sans'] font-extrabold uppercase tracking-wider shadow-sm">
                                        Bagian 3
                                    </span>
                                    <span class="text-2xl md:text-3xl">🚀</span>
                                </div>

                                <h2 class="text-lg md:text-xl text-[#1B5E20] leading-tight mb-2">
                                    Keputusan Investasi
                                </h2>

                                <p class="text-xs md:text-sm text-slate-700 font-['Plus_Jakarta_Sans'] leading-relaxed font-medium mb-4">
                                    Menilai keputusan investasi bisnis secara cermat agar bisnismu berkembang pesat dan mendapat keuntungan jangka panjang.
                                </p>
                            </div>

                            <button type="button" onclick="openSectionModal(3)" data-sfx="hover"
                                class="w-full rounded-2xl bg-gradient-to-b from-[#43A047] to-[#2E7D32] py-2.5 px-4 text-white text-xs md:text-sm tracking-wide shadow-[0_4px_0_rgba(0,0,0,0.15)] hover:brightness-110 active:translate-y-[2px] active:shadow-none transition-all">
                                Buka Bagian 3 📈
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Bottom Back to Menu Button -->
                <div class="absolute left-0 right-0 bottom-4 md:bottom-6 flex justify-center z-20">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95">
                        <img src="{{ asset('assets/keluar.png') }}" alt="Kembali ke Menu" class="w-28 md:w-36 h-auto drop-shadow-md">
                    </a>
                </div>

            </div>
        </div>

        <!-- Interactive Detail Modal -->
        <div id="sectionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div class="relative w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-3xl bg-white border-4 border-[#2D7BFF] p-6 md:p-8 shadow-2xl font-['Plus_Jakarta_Sans']">
                
                <!-- Close Button -->
                <button type="button" onclick="closeSectionModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 font-bold transition-transform active:scale-90">
                    ✕
                </button>

                <div id="modalContent"></div>

                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeSectionModal()" class="rounded-xl bg-[#2D7BFF] px-6 py-2.5 text-white font-bold text-sm shadow hover:bg-[#1f66de] transition-colors">
                        Tutup Materi
                    </button>
                </div>
            </div>
        </div>

        <script>
            const sectionData = {
                1: {
                    title: "Bagian 1: Menghubungkan Bisnis & Cara Mendapatkan Uang 💰",
                    badge: "Modul 1: Aliran Pendapatan",
                    badgeColor: "bg-[#FFA24A]",
                    content: `
                        <div class="space-y-4 text-slate-800">
                            <p class="text-sm md:text-base leading-relaxed">
                                Sebagai seorang <strong>pengusaha hebat</strong>, hal utama yang perlu kamu pahami adalah bagaimana bisnis menghasilkan uang. Uang didapatkan ketika kita mampu memberikan solusi atau manfaat bagi orang lain!
                            </p>

                            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-4 space-y-2">
                                <h4 class="font-bold text-amber-900 text-sm md:text-base">📌 Konsep Kunci:</h4>
                                <ul class="list-disc list-inside text-xs md:text-sm text-slate-700 space-y-1.5 leading-relaxed">
                                    <li><strong>Produk atau Jasa:</strong> Apa yang kamu tawarkan? (Contoh: makanan lezat, kerajinan tangan, atau jasa cuci sepatu).</li>
                                    <li><strong>Nilai Tambah:</strong> Kenapa orang mau membeli darimu dibandingkan tempat lain? (Kualitas lebih baik, lebih cepat, atau ramah).</li>
                                    <li><strong>Penetapan Harga:</strong> Menghitung harga jual agar menutup modal pembuatan dan menghasilkan keuntungan (laba).</li>
                                </ul>
                            </div>

                            <div class="rounded-2xl bg-sky-50 border border-sky-200 p-4">
                                <h4 class="font-bold text-sky-900 text-sm mb-1">💡 Tips Pengusaha Cilik:</h4>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed">
                                    "Selalu dengarkan apa yang disukai dan dibutuhkan oleh pembelimu. Pembeli yang puas akan selalu kembali dan mengajak teman-temannya!"
                                </p>
                            </div>
                        </div>
                    `
                },
                2: {
                    title: "Bagian 2: Menganalisis Rencana Pengeluaran & Tabungan Darurat 📊",
                    badge: "Modul 2: Manajemen Keuangan",
                    badgeColor: "bg-[#2D7BFF]",
                    content: `
                        <div class="space-y-4 text-slate-800">
                            <p class="text-sm md:text-base leading-relaxed">
                                Mendapatkan uang hanyalah satu sisi, mengelola pengeluaran dengan bijak adalah kunci agar bisnismu terus bertahan dan berkembang!
                            </p>

                            <div class="rounded-2xl bg-blue-50 border border-blue-200 p-4 space-y-2">
                                <h4 class="font-bold text-blue-900 text-sm md:text-base">📌 2 Langkah Wajib Pengusaha:</h4>
                                <div class="space-y-3 text-xs md:text-sm text-slate-700">
                                    <div>
                                        <strong>1. Memisahkan Kebutuhan vs Keinginan:</strong>
                                        <p class="text-slate-600 mt-0.5">Prioritaskan modal untuk bahan baku utama dan operasional penting sebelum membeli perlengkapan tambahan yang belum mendesak.</p>
                                    </div>
                                    <div>
                                        <strong>2. Membangun Tabungan Darurat:</strong>
                                        <p class="text-slate-600 mt-0.5">Selalu sisihkan sebagian keuntungan (misal 20%) ke dalam pos dana darurat untuk mengantisipasi harga bahan baku naik mendadak atau mesin/alat rusak.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4">
                                <h4 class="font-bold text-emerald-900 text-sm mb-1">🎯 Rumus Sederhana Keuangan:</h4>
                                <p class="text-xs md:text-sm text-slate-700 font-semibold">
                                    Keuntungan Bersih = Pendapatan Penjualan - Seluruh Pengeluaran Operasional.
                                </p>
                            </div>
                        </div>
                    `
                },
                3: {
                    title: "Bagian 3: Keputusan Investasi & Untung Masa Depan 🚀",
                    badge: "Modul 3: Pertumbuhan Bisnis",
                    badgeColor: "bg-[#43A047]",
                    content: `
                        <div class="space-y-4 text-slate-800">
                            <p class="text-sm md:text-base leading-relaxed">
                                Investasi adalah cara menggunakan sebagian keuntungan saat ini untuk membeli aset atau teknologi yang bisa melipatgandakan keuntungan bisnismu di masa depan!
                            </p>

                            <div class="rounded-2xl bg-green-50 border border-green-200 p-4 space-y-2">
                                <h4 class="font-bold text-green-900 text-sm md:text-base">📌 Cara Menilai Keputusan Investasi:</h4>
                                <ul class="list-disc list-inside text-xs md:text-sm text-slate-700 space-y-1.5 leading-relaxed">
                                    <li><strong>Peningkatan Kapasitas:</strong> Apakah membeli mixer otomatis bisa membuatmu memproduksi 5x lebih banyak kue dalam waktu sama?</li>
                                    <li><strong>Efisiensi Waktu & Biaya:</strong> Apakah alat baru bisa menghemat tenaga dan bahan baku yang terbuang?</li>
                                    <li><strong>Waktu Balik Modal (ROI):</strong> Hitung berapa lama keuntungan tambahan dari investasi tersebut akan mengembalikan modal yang dikeluarkan.</li>
                                </ul>
                            </div>

                            <div class="rounded-2xl bg-purple-50 border border-purple-200 p-4">
                                <h4 class="font-bold text-purple-900 text-sm mb-1">🏆 Jiwa Pengusaha Tangguh:</h4>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed">
                                    "Investasi terbaik bukan hanya pada barang, tetapi juga pada ilmu dan keterampilanmu dalam memimpin usaha!"
                                </p>
                            </div>
                        </div>
                    `
                }
            };

            function openSectionModal(id) {
                const data = sectionData[id];
                if (!data) return;

                const contentEl = document.getElementById('modalContent');
                contentEl.innerHTML = `
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 rounded-full ${data.badgeColor} text-white text-xs font-extrabold uppercase tracking-wider mb-2">
                            ${data.badge}
                        </span>
                        <h3 class="text-xl md:text-2xl font-black text-slate-900 font-['Paytone_One']">
                            ${data.title}
                        </h3>
                    </div>
                    ${data.content}
                `;

                document.getElementById('sectionModal').classList.remove('hidden');
            }

            function closeSectionModal() {
                document.getElementById('sectionModal').classList.add('hidden');
            }
        </script>
    </body>
</html>
