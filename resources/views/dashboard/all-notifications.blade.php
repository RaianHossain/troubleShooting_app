<x-backend.layouts.master>
    <x-slot name="pageTitle">
    Notifications
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Notifications </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">All Notifications</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="container">
        <!-- <h2 class="my-4">All Notifications</h2> -->
        @if($paginatedNotifications->count() > 0)
            <div class="card mb-3">
                <div class="card-body">
                    @foreach($paginatedNotifications as $notification)
                        <a href="{{ $notification->url }}" style="text-decoration: none; color: black;" class="list-group-item-action" onclick="makeSeen({{ $notification->id }}, {{ auth()->user()->id }})">
                            <div class="card mb-2">
                                @php $subscriber = unserialize($notification->subscriber); @endphp
                                <div class="card-body {{ $subscriber[auth()->user()->id] == 'unseen' ? 'bg-secondary text-white' : '' }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fas fa-bell me-2"></i>{{ $notification->message }}
                                        </div>
                                        <div>
                                            {{ str_replace([' day', ' days', ' weeks', ' week', ' month', ' months', ' year', ' years', ' ago'], ['d', 'd', 'w', 'w', 'm', 'm', 'y', 'y', ''], \Carbon\Carbon::parse($notification->created_at)->diffForHumans()) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $paginatedNotifications->links() }}
            </div>
        @else
            <p>No notifications found.</p>
        @endif
    </div>
    
</x-backend.layouts.master>