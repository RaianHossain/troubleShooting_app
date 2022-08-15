<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Winner Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Winner Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Winner Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('winners.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Winners Create

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
        <form action="{{ route('winners.store') }}" method="post">
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
                <select class="form-select" id="bid_id" name="bid_id">
                    <option selected>Choose...</option>
                    @foreach($bids as $bid)    
                        <option value="{{ $bid->id }}">{{ $bid->user->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Issue</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="position">Position</label>
                <input type="Number" class="form-control" id="position" aria-describedby="positionHelp" name="position" placeholder="Please Enter A Number Between 1-3">
                <small id="positionHelp" class="form-text text-muted">Write the position.</small>
            </div>

           
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>