<x-backend.layouts.master>
    <x-slot name="pageTitle">
        My Solved
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> My Solved </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">My Solved</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('issues.create') }}" class="btn btn-warning mb-3">Create New</a>
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Issues

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Uploaded By</th>
                        <th>Alarm</th>                        
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issue->uploaded_by->name ?? '' }}</td>
                            <td>{{ $issue->alarm ?? '' }}</td>
                            <td>{{ $issue->description ?? '' }}</td>
                            <td>
                                <a href="{{ route('issues.show', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-info">Show</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-backend.layouts.master>