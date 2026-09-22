@extends('admin.layout', ['title' => 'Dashboard Overview'])

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Banner (Clean White Theme) -->
    <div class="rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-sm relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-[#0077B6] text-xs font-extrabold uppercase tracking-wider mb-3">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                </svg>
                <span>Panel Pengelola Media</span>
            </span>
            <h2 class="font-['Jua'] text-2xl sm:text-3xl text-slate-900 mb-2 leading-tight">
                Selamat Datang di Administrator Bisnisku
            </h2>
            <p class="text-sm text-slate-600 leading-relaxed font-medium">
                Pantau progres belajar kewirausahaan siswa, evaluasi ide usaha & jawaban studi kasus yang masuk, serta unduh rekap data excel.
            </p>
        </div>
        <div class="shrink-0 flex items-center gap-3">
            <a href="{{ route('admin.submissions.export-excel') }}" 
               class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-emerald-600/25 transition-all flex items-center gap-2.5 active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span>Export Data Excel (.xlsx)</span>
            </a>
        </div>
    </div>

    <!-- KPI Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-[#0077B6] border border-sky-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <div class="font-['Jua'] text-3xl text-slate-900">{{ number_format($totalStudents) }}</div>
            <div class="text-xs font-semibold text-slate-400 mt-1">Siswa terdaftar di media</div>
        </div>

        <!-- Total Submissions -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Jawaban</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
            </div>
            <div class="font-['Jua'] text-3xl text-slate-900">{{ number_format($totalSubmissions) }}</div>
            <div class="text-xs font-semibold text-slate-400 mt-1">Semua interaksi modul</div>
        </div>

        <!-- Ide Bisnis Masuk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ide Bisnis Siswa</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.516 0c.85.493 1.508 1.333 1.508 2.316V18" />
                    </svg>
                </div>
            </div>
            <div class="font-['Jua'] text-3xl text-slate-900">{{ number_format($totalIdeBisnis) }}</div>
            <div class="text-xs font-semibold text-slate-400 mt-1">Sub-menu 1 (Ide Bisnis)</div>
        </div>

        <!-- Barang Game Belanja -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Item Game Belanja</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
            <div class="font-['Jua'] text-3xl text-slate-900">{{ number_format($totalSpendingItems) }}</div>
            <div class="text-xs font-semibold text-slate-400 mt-1">Sub-menu 2 (Katalog Game)</div>
        </div>

    </div>

    <!-- Main Content Grid: Recent Submissions & Recent Students -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Submissions Table (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-['Jua'] text-lg text-slate-900">Aktivitas Jawaban Terbaru</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftar ide dan jawaban yang baru dikirim siswa</p>
                </div>
                <a href="{{ route('admin.submissions.index') }}" class="text-xs font-bold text-[#0077B6] hover:text-[#005f92] transition-colors flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="flex-1 overflow-x-auto">
                @if ($recentSubmissions->isEmpty())
                    <div class="text-center py-12 text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <p class="text-sm font-bold text-slate-500">Belum ada jawaban siswa yang masuk.</p>
                        <p class="text-xs text-slate-400 mt-1">Jawaban yang diisi oleh siswa akan otomatis muncul di sini.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($recentSubmissions as $sub)
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
                                    'ide_bisnis' => 'Ide Bisnis',
                                    'game_belanja' => 'Game Belanja',
                                    'hitung_modal' => 'Hitung Modal',
                                    'studi_kasus_tabungan' => 'Kasus Tabungan',
                                    'studi_kasus_investasi' => 'Kasus Investasi',
                                    default => $sub->step_key
                                };
                            @endphp
                            <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-all flex items-start justify-between gap-4">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-sm text-slate-900 truncate">
                                            {{ $sub->user->name ?? 'Siswa Tamu' }}
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide border {{ $badgeColor }}">
                                            {{ $moduleName }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                        {{ $sub->answer_text ?? '-' }}
                                    </p>
                                </div>
                                <div class="shrink-0 text-right">
                                    <span class="text-[11px] font-semibold text-slate-400 block">
                                        {{ $sub->created_at ? $sub->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Registered Students (1 Column) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-['Jua'] text-lg text-slate-900">Siswa Baru</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftar siswa yang baru masuk</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-[#0077B6] hover:text-[#005f92] transition-colors flex items-center gap-1">
                    <span>Semua</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="flex-1">
                @if ($recentStudents->isEmpty())
                    <div class="text-center py-10 text-slate-400">
                        <p class="text-xs font-bold text-slate-500">Belum ada siswa terdaftar.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($recentStudents as $student)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-1 shrink-0">
                                        @if ($student->avatar === 'ce')
                                            <img src="{{ asset('assets/karakterce.png') }}" alt="Perempuan" class="w-full h-full object-contain">
                                        @else
                                            <img src="{{ asset('assets/karakterco.png') }}" alt="Laki-laki" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-sm text-slate-900 truncate">{{ $student->name }}</div>
                                        <div class="text-[11px] font-medium text-slate-400">
                                            {{ $student->avatar === 'ce' ? 'Perempuan' : 'Laki-laki' }}
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 shrink-0">
                                    {{ $student->created_at ? $student->created_at->format('d M H:i') : '-' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Quick Action Box -->
            <div class="mt-6 pt-4 border-t border-slate-100 space-y-2">
                <a href="{{ route('admin.spending-items.create') }}" class="w-full py-2.5 px-4 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm shadow-[#0077B6]/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Item Game Belanja</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
