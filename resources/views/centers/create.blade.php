<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Centers Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Centers Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Centers Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('centers.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Centers Create

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
        <form action="{{ route('centers.store') }}" method="post">
            @csrf
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name">
                <small id="nameHelp" class="form-text text-muted">Write the role name.</small>
            </div>

            <div class="form-group">
                <label for="name">City</label>
                <input type="text" class="form-control" id="city" aria-describedby="cityHelp" name="city">
                <small id="cityHelp" class="form-text text-muted">Write the City</small>
            </div>

            <div class="form-group">
                <label for="concern_person">Concern Person</label>
                <input type="text" class="form-control" id="concern_person" aria-describedby="concern_personHelp" name="concern_person">
                <small id="concern_personHelp" class="form-text text-muted">Write the concern person name</small>
            </div>
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>