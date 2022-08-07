<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Resolves
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Resolves </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Resolves</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('resolves.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            resolves

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Issue Id</th>
                        <th>Winner Id</th>
                        <th>Bid Id</th>
                        <th>Start Date</th>
                        <th>Submission Date</th>
                        <th>Extension Count</th>
                        <th>Extended Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($resolves as $resolve)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $resolve->id }}</td>
                            <td>{{ $resolve->user->name ?? '' }}</td>
                            <td>{{ $resolve->issue->id ?? '' }}</td>
                            <td>{{ $resolve->winner->id ?? '' }}</td>
                            <td>{{ $resolve->bid->id ?? '' }}</td>
                            <td>{{ $resolve->start_date }}</td>
                            <td>{{ $resolve->submission_date }}</td>
                            <td>{{ $resolve->extension_count }}</td>
                            <td>{{ $resolve->extended_date }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('resolves.delete', ['resolve_id' => $resolve->id]) }}" method="post">
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