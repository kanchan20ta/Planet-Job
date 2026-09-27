{{-- resources/views/admin/subscription-plans/partials/plan-card.blade.php --}}
@php
    $accentClasses = [
        'blue'  => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'ring' => 'focus:border-blue-500 focus:ring-blue-500/20'],
        'amber' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'ring' => 'focus:border-amber-500 focus:ring-amber-500/20'],
    ][$accent] ?? ['badge' => 'bg-gray-50 text-gray-700 border-gray-200', 'ring' => 'focus:border-brand-500 focus:ring-brand-500/20'];
@endphp

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 space-y-4">
    <form method="POST" action="{{ route('admin.subscription-plans.update', $plan) }}" class="space-y-4">
        @csrf @method('PUT')

        <div class="flex items-start justify-between gap-2">
            <input type="text" name="name" value="{{ $plan->name }}"
                class="w-full font-semibold rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm transition-colors {{ $accentClasses['ring'] }} focus:ring-2 focus:outline-none">
            <span class="shrink-0 mt-2 text-[11px] font-medium border rounded-full px-2.5 py-1 {{ $accentClasses['badge'] }}">
                {{ $plan->type === 'featured' ? 'Featured' : 'Latest' }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-400">$</span>
                    <input type="number" step="0.01" min="0" name="price" value="{{ $plan->price }}"
                        class="block w-full rounded-lg border border-gray-300 pl-6 pr-2 py-2 text-sm text-gray-900 shadow-sm transition-colors {{ $accentClasses['ring'] }} focus:ring-2 focus:outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Display Duration</label>
                <select name="duration_days"
                    class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm transition-colors {{ $accentClasses['ring'] }} focus:ring-2 focus:outline-none">
                    @foreach ([15, 30, 60, 90] as $days)
                        <option value="{{ $days }}" @selected($plan->duration_days == $days)>{{ $days }} days</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Job Limit</label>
                <input type="number" min="1" name="job_post_limit" value="{{ $plan->job_post_limit }}"
                    class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm transition-colors {{ $accentClasses['ring'] }} focus:ring-2 focus:outline-none">
            </div>

            @if ($plan->type === 'featured')
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Featured Slots</label>
                    <input type="number" min="1" name="featured_job_limit" value="{{ $plan->featured_job_limit }}"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm transition-colors {{ $accentClasses['ring'] }} focus:ring-2 focus:outline-none">
                </div>
            @else
                <div class="flex items-end pb-2">
                    <label class="flex items-center gap-1.5 text-xs text-gray-600">
                        <input type="checkbox" name="is_active" value="1" @checked($plan->is_active)
                            class="h-3.5 w-3.5 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
                        Active
                    </label>
                </div>
            @endif
        </div>

        @if ($plan->type === 'featured')
            <label class="flex items-center gap-1.5 text-xs text-gray-600">
                <input type="checkbox" name="is_active" value="1" @checked($plan->is_active)
                    class="h-3.5 w-3.5 rounded border-gray-300 text-brand-600 focus:ring-brand-500/30">
                Active
            </label>
        @endif

        <button class="w-full bg-gray-900 text-white font-medium rounded-lg py-2 text-xs hover:bg-gray-800 transition-colors">
            Update Plan
        </button>
    </form>

    <form method="POST" action="{{ route('admin.subscription-plans.destroy', $plan) }}" class="flex justify-center">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white hover:bg-red-600 rounded-lg px-4 py-1 text-[11px] font-medium transition-colors">
            Delete
        </button>
    </form>
</div>
