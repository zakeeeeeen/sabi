@extends('admin.layout', ['title' => 'Kelola Barang Game Belanja'])

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Explanation -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-['Jua'] text-xl text-slate-900">Katalog Barang Game "Atur Belanjamu"</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Kelola daftar pilihan belanja untuk simulasi modal Rp1.000.000 di Sub-menu 2 (Rencana Keuangan).
            </p>
        </div>
        <a href="{{ route('admin.spending-items.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white text-xs font-bold transition-all shadow-sm shadow-[#0077B6]/20 shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Barang Baru</span>
        </a>
    </div>

    <!-- Table of Items -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Urutan</th>
                        <th class="py-4 px-6">Nama Barang / Pengeluaran</th>
                        <th class="py-4 px-6">Harga / Biaya</th>
                        <th class="py-4 px-6">Kategori Belanja</th>
                        <th class="py-4 px-6">Kunci Jawaban Game</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-400">
                                #{{ $item->order_num }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $item->name }}
                            </td>
                            <td class="py-4 px-6 font-bold text-[#0077B6]">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $item->category ?? 'Produksi' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if ($item->is_correct)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        <span>Kebutuhan Pokok (Benar)</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                        <span>Keinginan / Tambahan (Salah)</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if ($item->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.spending-items.edit', $item->id) }}"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-[#0077B6] hover:text-white text-slate-600 transition-all text-xs font-bold inline-flex items-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.spending-items.destroy', $item->id) }}" onsubmit="return confirm('Hapus barang {{ $item->name }}?')">
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
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <p class="text-sm font-bold text-slate-500">Belum ada item belanja.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
