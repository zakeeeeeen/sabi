@extends('admin.layout', ['title' => 'Jawaban & Ide Siswa'])

@section('content')
<div class="space-y-6" x-data="{ 
    detailModal: false, 
    activeSubmission: null,
    openDetail(sub) {
        this.activeSubmission = sub;
        this.detailModal = true;
    }
}">

    <!-- Top Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
        
        <!-- Module Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            @php
                $modules = [
                    ['key' => '', 'label' => 'Semua Modul', 'count' => $counts['all']],
                    ['key' => 'ide_bisnis', 'label' => '1. Ide Bisnis', 'count' => $counts['ide_bisnis']],
                    ['key' => 'game_belanja', 'label' => '2. Game Belanja', 'count' => $counts['game_belanja']],
                    ['key' => 'hitung_modal', 'label' => '2. Hitung Modal', 'count' => $counts['hitung_modal']],
                    ['key' => 'studi_kasus_tabungan', 'label' => '3. Kasus Tabungan', 'count' => $counts['studi_kasus_tabungan']],
                    ['key' => 'studi_kasus_investasi', 'label' => '3. Kasus Investasi', 'count' => $counts['studi_kasus_investasi']],
                ];
            @endphp

            @foreach ($modules as $m)
                @php
                    $isSelected = ($stepFilter === $m['key'] || (empty($stepFilter) && empty($m['key'])));
                @endphp
                <a href="{{ route('admin.submissions.index', array_merge(request()->query(), ['module' => $m['key'], 'page' => 1])) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all border {{ $isSelected ? 'bg-[#0077B6] text-white border-[#0077B6] shadow-sm shadow-[#0077B6]/20' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span>{{ $m['label'] }}</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $isSelected ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700' }}">
                        {{ $m['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.submissions.index') }}" class="flex items-center gap-3">
            @if ($stepFilter)
                <input type="hidden" name="module" value="{{ $stepFilter }}">
            @endif
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari berdasarkan nama siswa..."
                       class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <button type="submit" class="h-11 px-5 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white text-xs font-bold transition-all shadow-sm shadow-[#0077B6]/20 shrink-0">
                Cari
            </button>
            @if ($search || $stepFilter)
                <a href="{{ route('admin.submissions.index') }}" class="h-11 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition-all flex items-center justify-center shrink-0">
                    Reset
                </a>
            @endif
            <a href="{{ route('admin.submissions.export-excel') }}" 
               class="h-11 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm shadow-emerald-600/25 flex items-center gap-2 shrink-0"
               title="Download Rekap Data Jawaban dalam Format Microsoft Excel">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span>Export Excel (.xlsx)</span>
            </a>
        </form>

    </div>

    <!-- Table of Submissions -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Siswa</th>
                        <th class="py-4 px-6">Modul Pembelajaran</th>
                        <th class="py-4 px-6">Isi Jawaban / Ide</th>
                        <th class="py-4 px-6">Waktu Masuk</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($submissions as $sub)
                        @php
                            $badgeColor = match($sub->step_key) {
                                'ide_bisnis' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'game_belanja' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'hitung_modal' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'studi_kasus_tabungan' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'studi_kasus_investasi' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200'
                            };
                            $moduleName = match($sub->step_key) {
                                'ide_bisnis' => '1. Ide Bisnis',
                                'game_belanja' => '2. Game Belanja',
                                'hitung_modal' => '2. Hitung Modal',
                                'studi_kasus_tabungan' => '3. Studi Tabungan',
                                'studi_kasus_investasi' => '3. Studi Investasi',
                                default => $sub->step_key
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center p-0.5 shrink-0">
                                        @if (($sub->user->avatar ?? '') === 'ce')
                                            <img src="{{ asset('assets/karakterce.png') }}" alt="Perempuan" class="w-full h-full object-contain">
                                        @else
                                            <img src="{{ asset('assets/karakterco.png') }}" alt="Laki-laki" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <span class="font-bold text-slate-900">{{ $sub->user->name ?? 'Siswa (Telah Dihapus)' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold border {{ $badgeColor }}">
                                    {{ $moduleName }}
                                </span>
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-medium">
                                    {{ $sub->answer_text ?? '-' }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-400 font-medium whitespace-nowrap">
                                {{ $sub->created_at ? $sub->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button"
                                            @click="openDetail({{ json_encode([
                                                'id' => $sub->id,
                                                'student_name' => $sub->user->name ?? 'Siswa Tamu',
                                                'avatar' => $sub->user->avatar ?? 'co',
                                                'module_name' => $moduleName,
                                                'step_key' => $sub->step_key,
                                                'answer_text' => $sub->answer_text,
                                                'payload' => $sub->payload,
                                                'created_at' => $sub->created_at ? $sub->created_at->translatedFormat('d F Y, H:i:s') : '-'
                                            ]) }})"
                                            class="p-2 rounded-xl bg-slate-100 hover:bg-[#0077B6] hover:text-white text-slate-600 transition-all text-xs font-bold inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span>Detail</span>
                                    </button>

                                    <form method="POST" action="{{ route('admin.submissions.destroy', $sub->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?')">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-xl bg-red-50 hover:bg-red-500 hover:text-white text-red-600 transition-all text-xs font-bold inline-flex items-center border border-red-100">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <p class="text-sm font-bold text-slate-500">Tidak ada jawaban siswa ditemukan.</p>
                                <p class="text-xs text-slate-400 mt-1">Coba sesuaikan filter atau kata kunci pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($submissions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

    <!-- Detail Submission Modal -->
    <div x-show="detailModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/30 backdrop-blur-xs flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.away="detailModal = false"
             class="w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-[#0077B6] border border-sky-100 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-['Jua'] text-base text-slate-900">Detail Jawaban Siswa</h3>
                        <p class="text-xs text-slate-500 font-medium" x-text="activeSubmission?.module_name"></p>
                    </div>
                </div>
                <button @click="detailModal = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                
                <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Nama Siswa</span>
                        <span class="font-bold text-sm text-slate-900" x-text="activeSubmission?.student_name"></span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Waktu Submit</span>
                        <span class="text-xs font-semibold text-slate-600" x-text="activeSubmission?.created_at"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Teks Jawaban Siswa:</label>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-sm text-slate-800 leading-relaxed font-medium whitespace-pre-line max-h-60 overflow-y-auto"
                         x-text="activeSubmission?.answer_text"></div>
                </div>

                <template x-if="activeSubmission?.payload">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-2">Struktur Payload Data:</label>
                        <pre class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-mono overflow-x-auto max-h-40"
                             x-text="JSON.stringify(activeSubmission?.payload, null, 2)"></pre>
                    </div>
                </template>

            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button @click="detailModal = false" class="px-5 py-2.5 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white text-xs font-bold transition-all shadow-sm shadow-[#0077B6]/20">
                    Tutup
                </button>
            </div>

        </div>

    </div>

</div>
@endsection
