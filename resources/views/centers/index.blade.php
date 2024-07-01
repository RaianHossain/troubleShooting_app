<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Centers
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Centers </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Centers</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('centers.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Centers

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Name</th>
                        <th>Center Id</th>
                        <th>City</th>
                        <th>Concern Person</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($centers as $center)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $center->name ?? '' }}</td>
                            <td>{{ $center->id }}</td>
                            <td>{{ $center->city }}</td>
                            <td>{{ $center->concern_person }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('centers.delete', ['center_id' => $center->id]) }}" method="post">
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