<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Time Extend Requests
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Time Extend Requests </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Time Extend Requests</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

        
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Time Extend Requests

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Reason</th>
                        <th>User</th>                        
                        <th>Alarm</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $request->reason ?? '' }}</td>
                            <td>{{ $request->user->name ?? '' }}</td>
                            <td>{{ $request->issue->alarm ?? '' }}</td>
                            <td>
                                <a href="#" class="btn btn-warning">Approve</a>
                                <a href="#" class="btn btn-warning">Reject</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-backend.layouts.master>

