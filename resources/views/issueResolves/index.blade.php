<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Issue Resolves
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Issue Resolves </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Issue Resolves</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    {{--<a href="{{ route('issueResolves.create') }}" class="btn btn-warning mb-3">Create New</a>--}}

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Issue Resolves

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Issue Id</th>
                        <th>User</th>
                        <th>Extension Count</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($issueResolves as $issueResolve)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issueResolve->issue->id ?? '' }}</td>
                            <td>{{ $issueResolve->user->id ?? '' }}</td>
                            <td>{{ $issueResolve->extension_count ?? '' }}</td>
                            <td>{{ $issueResolve->status ?? '' }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('issueResolves.delete', ['issueResolve_id' => $issueResolve->id]) }}" method="post">
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