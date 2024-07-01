<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Roles
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Roles </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('roles.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Roles

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Name</th>
                        <th>Role Id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $role->name ?? '' }}</td>
                            <td>{{ $role->id }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('roles.delete', ['role_id' => $role->id]) }}" method="post">
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