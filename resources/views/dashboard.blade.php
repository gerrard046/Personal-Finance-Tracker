<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">💰 Personal Finance Tracker</h1>
                <p class="text-gray-600">Pantau pengeluaran Anda dan hindari boros dengan logika "Anti-Boros"</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">✅ {{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Dashboard -->
                <div class="lg:col-span-2">
                    <!-- Balance Card -->
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">
                            Total Saldo Saat Ini
                        </h2>
                        <div class="flex items-baseline gap-2 mb-8">
                            <span class="text-5xl font-bold text-gray-900">
                                Rp {{ number_format($currentBalance, 0, ',', '.') }}
                            </span>
                            <span class="text-lg text-gray-500">IDR</span>
                        </div>

                        <!-- Income vs Expense Breakdown -->
                        <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Pemasukan 📈</p>
                                <p class="text-2xl font-bold text-green-600">
                                    +Rp {{ number_format($totalIncome, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Pengeluaran 📉</p>
                                <p class="text-2xl font-bold text-red-600">
                                    -Rp {{ number_format(abs($totalExpense), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Anti-Boros Indicator Card -->
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-6">
                            🎯 Indikator Anti-Boros
                        </h2>

                        <!-- Status Color Indicator -->
                        <div class="mb-8">
                            @if ($status['color'] === 'green')
                                <div class="flex items-center gap-4 p-4 bg-green-50 border-2 border-green-500 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white">
                                            ✓
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-green-900">{{ $status['label'] }}</h3>
                                        <p class="text-green-700">{{ $status['message'] }}</p>
                                    </div>
                                </div>
                            @elseif ($status['color'] === 'yellow')
                                <div class="flex items-center gap-4 p-4 bg-yellow-50 border-2 border-yellow-500 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-500 text-white">
                                            ⚠
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-yellow-900">{{ $status['label'] }}</h3>
                                        <p class="text-yellow-700">{{ $status['message'] }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-4 p-4 bg-red-50 border-2 border-red-500 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-500 text-white">
                                            ✕
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-red-900">{{ $status['label'] }}</h3>
                                        <p class="text-red-700">{{ $status['message'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Daily Safe Limit Explanation -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <h3 class="font-bold text-blue-900 mb-2">📊 Daily Safe Limit</h3>
                            <p class="text-blue-800 text-sm mb-3">
                                Estimasi berapa banyak uang yang bisa Anda keluarkan setiap hari tanpa terlalu boros.
                            </p>
                            <p class="text-3xl font-bold text-blue-900 mb-2">
                                Rp {{ number_format($dailySafeLimit, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-blue-700">
                                Sisa {{ $daysLeftInMonth }} hari lagi dalam bulan ini
                            </p>
                        </div>
                    </div>

                    <!-- Recent Transactions Section -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">📋 Transaksi 5 Terakhir</h2>

                        @if ($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentTransactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                        <!-- Icon & Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <span class="text-2xl">
                                                    @if ($transaction->type === 'income')
                                                        📈
                                                    @else
                                                        📉
                                                    @endif
                                                </span>
                                                <div>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $transaction->item_name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $transaction->category }} · {{ $transaction->created_at->format('d M Y - H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($transaction->note)
                                                <p class="text-sm text-gray-600 ml-11">
                                                    💬 {{ $transaction->note }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Amount -->
                                        <div class="text-right">
                                            <p class="text-lg font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                                Rp {{ number_format(abs($transaction->amount), 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-500 text-lg">
                                    Belum ada transaksi. Mulai catat pengeluaran Anda! 👇
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Form Input -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-8 sticky top-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">➕ Catat Transaksi Baru</h2>

                        <form action="{{ route('transaction.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Item Name -->
                            <div>
                                <label for="item_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Item / Deskripsi
                                </label>
                                <input
                                    type="text"
                                    name="item_name"
                                    id="item_name"
                                    placeholder="Contoh: Beli Roti, Bensin Motor"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('item_name') border-red-500 @enderror"
                                    required
                                    value="{{ old('item_name') }}"
                                >
                                @error('item_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type Selection -->
                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenis Transaksi
                                </label>
                                <select
                                    name="type"
                                    id="type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror"
                                    required
                                    onchange="updateCategoryOptions()"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>
                                        📉 Pengeluaran
                                    </option>
                                    <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>
                                        📈 Pemasukan
                                    </option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori
                                </label>
                                <select
                                    name="category"
                                    id="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    <!-- Kategori akan berubah saat type diubah -->
                                    <option value="Makanan" {{ old('category') === 'Makanan' ? 'selected' : '' }}>
                                        🍔 Makanan & Minuman
                                    </option>
                                    <option value="Transport" {{ old('category') === 'Transport' ? 'selected' : '' }}>
                                        🚗 Transport
                                    </option>
                                    <option value="Entertainment" {{ old('category') === 'Entertainment' ? 'selected' : '' }}>
                                        🎬 Entertainment
                                    </option>
                                    <option value="Utilitas" {{ old('category') === 'Utilitas' ? 'selected' : '' }}>
                                        💡 Utilitas
                                    </option>
                                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>
                                        ℹ️ Lainnya
                                    </option>
                                </select>
                                @error('category')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jumlah (Rp)
                                </label>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    placeholder="0"
                                    step="0.01"
                                    min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                                    required
                                    value="{{ old('amount') }}"
                                >
                                @error('amount')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Note -->
                            <div>
                                <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea
                                    name="note"
                                    id="note"
                                    placeholder="Tambahkan informasi lebih detail tentang transaksi ini"
                                    rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('note') border-red-500 @enderror"
                                    value="{{ old('note') }}"
                                ></textarea>
                                @error('note')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition duration-200 transform hover:scale-105"
                            >
                                ✅ Simpan Transaksi
                            </button>
                        </form>

                        <!-- Tips Section -->
                        <div class="mt-8 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                            <h3 class="font-bold text-green-900 mb-2">💡 Tips Menghindari Boros</h3>
                            <ul class="text-sm text-green-800 space-y-1">
                                <li>✓ Perhatikan Daily Safe Limit Anda</li>
                                <li>✓ Catat setiap pengeluaran (no matter how small)</li>
                                <li>✓ Review pengeluaran Anda setiap minggu</li>
                                <li>✓ Fokus pada kategori dengan pengeluaran terbesar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk mengubah kategori berdasarkan tipe transaksi -->
    <script>
        function updateCategoryOptions() {
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category');
            const type = typeSelect.value;

            // Reset kategori
            categorySelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';

            if (type === 'expense') {
                const expenseCategories = [
                    { value: 'Makanan', label: '🍔 Makanan & Minuman' },
                    { value: 'Transport', label: '🚗 Transport' },
                    { value: 'Entertainment', label: '🎬 Entertainment' },
                    { value: 'Utilitas', label: '💡 Utilitas' },
                    { value: 'Belanja', label: '🛍️ Belanja' },
                    { value: 'Kesehatan', label: '⚕️ Kesehatan' },
                    { value: 'Lainnya', label: 'ℹ️ Lainnya' },
                ];

                expenseCategories.forEach((cat) => {
                    const option = document.createElement('option');
                    option.value = cat.value;
                    option.textContent = cat.label;
                    categorySelect.appendChild(option);
                });
            } else if (type === 'income') {
                const incomeCategories = [
                    { value: 'Gaji', label: '💰 Gaji' },
                    { value: 'Bonus', label: '🎁 Bonus' },
                    { value: 'Investasi', label: '📈 Return Investasi' },
                    { value: 'Freelance', label: '💻 Freelance' },
                    { value: 'Lainnya', label: 'ℹ️ Lainnya' },
                ];

                incomeCategories.forEach((cat) => {
                    const option = document.createElement('option');
                    option.value = cat.value;
                    option.textContent = cat.label;
                    categorySelect.appendChild(option);
                });
            }
        }
    </script>
</body>
</html>
