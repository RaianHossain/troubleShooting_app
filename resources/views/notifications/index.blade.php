<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Notifications
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Notifications </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Notifications</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('notifications.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Notifications

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Id</th>
                        <th>Notfications</th>
                        <th>Subscriber</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $notification->id ?? '' }}</td>
                            <td>{{ $notification->notification ?? '' }}</td>
                            <th>@if(!is_null($notification->subscriber))<ul>@foreach($notification->subscriber as $subscriber) <li>{{ $subscriber->name }}</li> @endforeach @else No Subscribers @endif</th>
                            <td>
                                <form style="display:inline" action="{{ route('notifications.delete', ['notification_id' => $notification->id]) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-backend.layouts.master>