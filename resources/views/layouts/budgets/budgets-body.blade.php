<div class="row">
    <p>Total Budget : <span class="text-success">{{ $totalBudget }} TK</span></p>
    <p>Total Spent : <span class="text-danger">{{ $totalSpent }} TK</span></p>
    <p>Remaining : <span class="text-success">{{ $totalBudget - $totalSpent > 0 ? $totalBudget - $totalSpent : 0 }} TK</span></p>
</div>
@if ($totalBudget != 0 or $totalSpent != 0)
    @if ($totalBudget - $totalSpent > 0)
        <div class="progress" style="margin-top: 10px;">
            <div class="progress-bar bg-teal" style="width: {{ round((100 * $totalSpent) / $totalBudget, 2) }}%" aria-valuenow="{{ round((100 * $totalSpent) / $totalBudget, 2) }}" aria-valuemin="0" aria-valuemax="100">{{ round((100 * $totalSpent) / $totalBudget, 2) }}% complete</div>
        </div>
    @else
        <div class="progress" style="margin-top: 10px;">
            <div class="progress-bar bg-teal bg-danger" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                Limit exceeded {{ $totalSpent - $totalBudget }} TK
            </div>
        </div>
    @endif
@endif