<?php

namespace App\Http\Controllers\Api;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class GoalController extends Controller
{
    /**
     * GET /api/goals - List semua goals user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $goals = Goal::where('user_id', $user->id)
            ->when($request->status, function($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($goal) {
                return $this->formatGoal($goal);
            });

        return response()->json([
            'success' => true,
            'data' => $goals,
            'count' => $goals->count(),
        ]);
    }

    /**
     * POST /api/goals - Create goal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'target_date' => 'nullable|date|after:today',
        ]);

        $validated['user_id'] = $request->user()->id;
        $goal = Goal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Goal berhasil dibuat',
            'data' => $this->formatGoal($goal),
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/goals/{id} - Detail goal
     */
    public function show(Request $request, Goal $goal)
    {
        $this->authorize('view', $goal);

        return response()->json([
            'success' => true,
            'data' => $this->formatGoal($goal),
        ]);
    }

    /**
     * PUT /api/goals/{id} - Update goal
     */
    public function update(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'goal_name' => 'nullable|string|max:255',
            'target_amount' => 'nullable|numeric|min:0.01',
            'current_saved' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'target_date' => 'nullable|date|after:today',
            'status' => 'nullable|in:active,completed,cancelled',
        ]);

        // Auto-complete jika current_saved >= target_amount
        if (isset($validated['current_saved'])) {
            if ($validated['current_saved'] >= $goal->target_amount) {
                $validated['status'] = 'completed';
            }
        }

        $goal->update(array_filter($validated));

        return response()->json([
            'success' => true,
            'message' => 'Goal berhasil diupdate',
            'data' => $this->formatGoal($goal),
        ]);
    }

    /**
     * DELETE /api/goals/{id} - Hapus goal
     */
    public function destroy(Request $request, Goal $goal)
    {
        $this->authorize('delete', $goal);

        $goal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Goal berhasil dihapus',
        ]);
    }

    /**
     * POST /api/goals/{id}/save - Add savings ke goal
     */
    public function addSavings(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $newSaved = $goal->current_saved + $validated['amount'];
        
        $goal->update([
            'current_saved' => $newSaved,
            'status' => $newSaved >= $goal->target_amount ? 'completed' : 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Savings berhasil ditambahkan',
            'data' => $this->formatGoal($goal),
        ]);
    }

    /**
     * Format goal dengan calculated fields
     */
    private function formatGoal(Goal $goal)
    {
        return [
            'id' => $goal->id,
            'goal_name' => $goal->goal_name,
            'target_amount' => (float) $goal->target_amount,
            'current_saved' => (float) $goal->current_saved,
            'remaining_amount' => (float) $goal->getRemainingAmount(),
            'progress_percentage' => $goal->getProgressPercentage(),
            'category' => $goal->category,
            'description' => $goal->description,
            'target_date' => $goal->target_date?->format('Y-m-d'),
            'days_remaining' => $goal->getDaysRemaining(),
            'target_per_day' => (float) $goal->getTargetPerDay(),
            'target_per_month' => (float) $goal->getTargetPerMonth(),
            'status' => $goal->status,
            'is_completed' => $goal->isCompleted(),
            'created_at' => $goal->created_at->toIso8601String(),
            'updated_at' => $goal->updated_at->toIso8601String(),
        ];
    }
}
