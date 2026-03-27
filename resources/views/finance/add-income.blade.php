@extends('layouts.app')

@section('title', 'Tambah Saldo/Pemasukan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-700 mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
            <div class="flex items-center">
                <i class="fas fa-plus-circle text-green-500 text-3xl mr-4"></i>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tambah Saldo/Pemasukan</h1>
                    <p class="text-gray-600 mt-1">Catat pemasukan atau saldo baru Anda</p>
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                    placeholder="Contoh: Gaji bulanan, Bonus, Investasi..."
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Gaji" {{ old('category') == 'Gaji' ? 'selected' : '' }}>💼 Gaji</option>
                        <option value="Bonus" {{ old('category') == 'Bonus' ? 'selected' : '' }}>🎁 Bonus</option>
                        <option value="Investasi" {{ old('category') == 'Investasi' ? 'selected' : '' }}>📈 Investasi</option>
                        <option value="Bisnis" {{ old('category') == 'Bisnis' ? 'selected' : '' }}>🏢 Bisnis</option>
                        <option value="Insentif" {{ old('category') == 'Insentif' ? 'selected' : '' }}>⭐ Insentif</option>
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
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                    placeholder="Tambahkan catatan atau keterangan lebih lengkap..."
                >{{ old('note') }}</textarea>
                @error('note')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden input untuk type -->
            <input type="hidden" name="type" value="income">

            <div class="flex gap-4">
                <button 
                    type="submit"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition flex items-center justify-center"
                >
                    <i class="fas fa-check mr-2"></i>Simpan Pemasukan
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
