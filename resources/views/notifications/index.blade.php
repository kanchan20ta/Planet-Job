@extends('layouts.app')
@section('title', 'Notifications - Planet Job Portal')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-14">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
            @csrf
            <button class="text-sm text-brand-600 font-medium">Mark all as read</button>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">
        @forelse ($notifications as $notification)
            <div class="p-4 flex items-center justify-between text-sm {{ $notification->read_at ? '' : 'bg-brand-50/50' }}">
                <div>
                    <p class="text-gray-800">
                        @if (($notification->data['type'] ?? '') === 'new_application')
                            New application from {{ $notification->data['applicant_name'] }} for "{{ $notification->data['job_title'] }}"
                        @elseif (($notification->data['type'] ?? '') === 'application_status_updated')
                            Your application for "{{ $notification->data['job_title'] }}" is now {{ $notification->data['status'] }}
                        @else
                            {{ $notification->data['message'] ?? 'New notification' }}
                        @endif
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @unless ($notification->read_at)
                    <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                        @csrf
                        <button class="text-xs text-brand-600">Mark read</button>
                    </form>
                @endunless
            </div>
        @empty
            <p class="p-8 text-center text-gray-400 text-sm">No notifications yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
</div>
@endsection
