<x-backend.layouts.master>
    <x-slot name="pageTitle">
    Dashboard
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Dashboard </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <!-- <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div> -->
    {{--list-group-item --}}
    @if($notifications)
        <div class="card mb-3">
            <div class="card-header navbar-custom text-white fw-bold">
                Notification
            </div>
            <div class="card-body">
                @foreach($notifications as $notification)
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
                <div class="text-center mt-3">
                    <a href="{{ route('notifications.all') }}" class="btn btn-link">See all notifications</a>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Completed Task of {{ $currentYear }}
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <!-- <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Your Points This Year
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div> -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Score Distribution
                </div>
                <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Embed chart data as a JavaScript variable -->
    <script>
        var chartData = @json($chartData);
        var pieChartNames = @json($pieChartNames);
        var pieChartPercentages = @json($pieChartPercentages)
    </script>
    

    <script>
        function makeSeen(notification_id, user_id) {
            const base_url = "<?php echo env('APP_URL'); ?>"
            const fetch_url = base_url+`/api/make-notification-seen/${notification_id}/${user_id}`
            // alert(fetch_url);
            fetch(fetch_url);
        }
    </script>

    

</x-backend.layouts.master>