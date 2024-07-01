<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Resolves Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Resolves Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Resolves Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('resolves.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Resolves Create

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
        <form action="{{ route('resolves.store') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <select class="form-select" id="issue_id" name="issue_id">
                    <option selected>Choose...</option>
                    @foreach($issues as $issue)    
                        <option value="{{ $issue->id }}">{{ $issue->alarm }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Issue</label>
                </div>
            </div>

            <div class="input-group mb-3">
                <select class="form-select" id="user_id" name="user_id">
                    <option selected>Choose...</option>
                    @foreach($users as $user)    
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">User</label>
                </div>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="text" class="form-control" id="start_date" aria-describedby="start_dateHelp" name="start_date" placeholder="mm-dd-yy">
                <small id="start_dateHelp" class="form-text text-muted">Write the start date.</small>
            </div>

            <div class="form-group">
                <label for="extended_date">Extended Date</label>
                <input type="text" class="form-control" id="extended_date" aria-describedby="extended_dateHelp" name="extended_date" placeholder="mm-dd-yy">
                <small id="extended_dateHelp" class="form-text text-muted">Write the start date.</small>
            </div>

            
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>