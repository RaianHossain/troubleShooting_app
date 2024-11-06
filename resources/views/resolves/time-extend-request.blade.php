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

        
            <table class="table table-bordered" id="requestTable">
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
                                <a href="{{ route('resolves.approve', ['resolve_id' => $request->resolve_id, 'request_id' => $request->id]) }}" class="btn btn-warning">Approve</a>
                                <a href="{{ route('resolves.reject', ['resolve_id' => $request->resolve_id, 'request_id' => $request->id]) }}" class="btn btn-warning">Reject</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#requestTable').DataTable();
        });
    </script>


</x-backend.layouts.master>

