<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * GET /api/transactions - List semua transaksi user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $transactions = Transaction::where('user_id', $user->id)
            ->when($request->type, function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->category, function($query) use ($request) {
                return $query->where('category', $request->category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $transactions->items(),
            'pagination' => [
                'total' => $transactions->total(),
                'count' => $transactions->count(),
                'per_page' => $transactions->perPage(),
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
            ],
        ]);
    }

    /**
     * POST /api/transactions - Create transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'note' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['amount'] = abs($validated['amount']);

        $transaction = Transaction::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'data' => $transaction,
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/transactions/{id} - Detail transaksi
     */
    public function show(Request $request, Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }

    /**
     * PUT /api/transactions/{id} - Update transaksi
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'item_name' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|in:income,expense',
            'note' => 'nullable|string|max:500',
        ]);

        if (isset($validated['amount'])) {
            $validated['amount'] = abs($validated['amount']);
        }

        $transaction->update(array_filter($validated));

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diupdate',
            'data' => $transaction,
        ]);
    }

    /**
     * DELETE /api/transactions/{id} - Hapus transaksi
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus',
        ]);
    }

    /**
     * GET /api/transactions/stats/summary - Summary statistik
     */
    public function summary(Request $request)
    {
        $user = $request->user();

        $incomes = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
        
        $expenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');
        
        $balance = $incomes - $expenses;

        return response()->json([
            'success' => true,
            'data' => [
                'total_income' => (float) $incomes,
                'total_expense' => (float) $expenses,
                'current_balance' => (float) $balance,
            ],
        ]);
    }
}
