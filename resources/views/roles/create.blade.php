<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Roles Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Roles Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('roles.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Roles Create

        </div>
        <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name">
                <small id="nameHelp" class="form-text text-muted">Write the role name.</small>
            </div>
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>