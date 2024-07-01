<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Users Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Users Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Users Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('users.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Users Create

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
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            
            <div class="form-group">
                <label for="user">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name">
                <small id="nameHelp" class="form-text text-muted">Write the user name.</small>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                <small id="emailHelp" class="form-text text-muted">Write the user email.</small>
            </div>            

            <div class="input-group mb-3">
                <select class="form-select" id="center_id" name="center_id">
                    <option selected>Choose...</option>
                    @foreach($centers as $center)    
                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Center</label>
                </div>
            </div>

            <div class="input-group mb-3">
                <select class="form-select" id="role_id" name="role_id">
                    <option selected>Choose...</option>
                    @foreach($roles as $role)    
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Role</label>
                </div>
            </div>
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>