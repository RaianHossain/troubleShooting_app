<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Engineers Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Engineers Create </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Engineers Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('engineers.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Engineers Create

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
        <form action="{{ route('engineers.store') }}" method="post">
            @csrf
            
            <div class="form-group mb-3">
                <label for="user">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
            </div>            

            <label for="center_id">Center</label>
            <div class="input-group mb-3">
                <select class="form-select form-control" aria-label="Default select example" name="center_id" id="center_id">
                    <option selected>Choose One...</option>
                    @foreach($centers as $center)    
                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                    @endforeach
                </select>
                
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Center</label>
                </div>
            </div>           
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>