@extends('admin.layout', ['title' => ($isEdit ? 'Edit Barang Belanja' : 'Tambah Barang Belanja')])

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h2 class="font-['Jua'] text-xl text-slate-900">
                    {{ $isEdit ? 'Edit Item Barang' : 'Tambah Item Barang Baru' }}
                </h2>
                <p class="text-xs text-slate-500 font-medium">
                    Item untuk simulasi game Atur Belanjamu (Sub-menu 2)
                </p>
            </div>
            <a href="{{ route('admin.spending-items.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                ← Kembali
            </a>
        </div>

        <form method="POST" action="{{ $isEdit ? route('admin.spending-items.update', $item->id) : route('admin.spending-items.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1.5" for="name">
                    Nama Barang / Pengeluaran <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" required
                       placeholder="Contoh: Alat dan Bahan Baku Kerajinan Kerang"
                       class="w-full h-11 px-4 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1.5" for="price">
                        Harga / Biaya (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', $item->price) }}" required min="0" step="1000"
                           placeholder="Contoh: 300000"
                           class="w-full h-11 px-4 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1.5" for="category">
                        Kategori Tampilan
                    </label>
                    <input type="text" id="category" name="category" value="{{ old('category', $item->category ?? 'Produksi') }}"
                           placeholder="Contoh: Produksi / Promosi / Operasional"
                           class="w-full h-11 px-4 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-800">
                    Kunci Jawaban Game "Atur Belanjamu" <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <label class="flex items-start gap-3 p-3 rounded-xl bg-white border border-slate-200 cursor-pointer hover:border-emerald-300">
                        <input type="radio" name="is_correct" value="1" {{ old('is_correct', $item->is_correct ? '1' : '0') === '1' ? 'checked' : '' }} class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">Kebutuhan Pokok Produksi (Jawaban Benar)</span>
                            <span class="block text-[11px] text-slate-500">Item ini wajib dipilih siswa untuk memenangkan simulasi belanja.</span>
                        </div>
                    </label>
                    <label class="flex items-start gap-3 p-3 rounded-xl bg-white border border-slate-200 cursor-pointer hover:border-rose-300">
                        <input type="radio" name="is_correct" value="0" {{ old('is_correct', $item->is_correct ? '1' : '0') === '0' ? 'checked' : '' }} class="mt-0.5 text-rose-600 focus:ring-rose-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">Keinginan / Tambahan Non-Pokok (Salah)</span>
                            <span class="block text-[11px] text-slate-500">Item pengeluaran tambahan yang bukan merupakan prioritas awal produksi.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1.5" for="order_num">
                        Urutan Tampil <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="order_num" name="order_num" value="{{ old('order_num', $item->order_num) }}" required min="1"
                           class="w-full h-11 px-4 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1.5" for="is_active">
                        Status Keaktifan <span class="text-red-500">*</span>
                    </label>
                    <select id="is_active" name="is_active"
                            class="w-full h-11 px-3.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                        <option value="1" {{ old('is_active', $item->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif (Ditampilkan ke Siswa)</option>
                        <option value="0" {{ old('is_active', $item->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.spending-items.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white text-xs font-bold transition-all shadow-sm shadow-[#0077B6]/20">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Barang' }}
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
