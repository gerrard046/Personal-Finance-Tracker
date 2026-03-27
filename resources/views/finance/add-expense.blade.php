@extends('layouts.app')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
            <div class="flex items-center">
                <i class="fas fa-minus-circle text-red-500 text-3xl mr-4"></i>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tambah Pengeluaran</h1>
                    <p class="text-gray-600 mt-1">Catat pengeluaran atau transaksi keluar Anda</p>
                </div>
            </div>
        </div>

        <form action="{{ route('transaction.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-list mr-2"></i>Nama Item/Keterangan
                </label>
                <input 
                    type="text" 
                    name="item_name" 
                    value="{{ old('item_name') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Contoh: Makan, Bensin, Liburan, Medical Check-up..."
                    required
                >
                @error('item_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-dollar-sign mr-2"></i>Jumlah (Rp)
                    </label>
                    <input 
                        type="number" 
                        name="amount" 
                        value="{{ old('amount') }}"
                        step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                        placeholder="0.00"
                        required
                    >
                    @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Kategori
                    </label>
                    <select 
                        name="category"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>🍔 Makanan & Minuman</option>
                        <option value="Transportasi" {{ old('category') == 'Transportasi' ? 'selected' : '' }}>🚗 Transportasi</option>
                        <option value="Belanja" {{ old('category') == 'Belanja' ? 'selected' : '' }}>🛍️ Belanja Barang</option>
                        <option value="Kesehatan" {{ old('category') == 'Kesehatan' ? 'selected' : '' }}>🏥 Kesehatan</option>
                        <option value="Hiburan" {{ old('category') == 'Hiburan' ? 'selected' : '' }}>🎬 Hiburan</option>
                        <option value="Utilitas" {{ old('category') == 'Utilitas' ? 'selected' : '' }}>💡 Listrik & Air</option>
                        <option value="Cicilan" {{ old('category') == 'Cicilan' ? 'selected' : '' }}>💳 Cicilan/Hutang</option>
                        <option value="Zakat" {{ old('category') == 'Zakat' ? 'selected' : '' }}>💰 Zakat/Sedekah</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>
                    @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Catatan/Keterangan (Opsional)
                </label>
                <textarea 
                    name="note" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Tambahkan catatan atau keterangan lebih lengkap..."
                >{{ old('note') }}</textarea>
                @error('note')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden input untuk type -->
            <input type="hidden" name="type" value="expense">

            <div class="flex gap-4">
                <button 
                    type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg transition flex items-center justify-center"
                >
                    <i class="fas fa-check mr-2"></i>Simpan Pengeluaran
                </button>
                <a 
                    href="{{ route('dashboard') }}"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition flex items-center justify-center"
                >
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
