<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Engineers
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Engineers </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Engineers</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('engineers.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Engineers

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Center</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($engineers as $engineer)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $engineer->name ?? '' }}</td>
                            <td>{{ $engineer->email ?? '' }}</td>
                            <td>{{ $engineer->center->name ?? '' }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('engineers.delete', ['engineer_id' => $engineer->id]) }}" method="post">
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