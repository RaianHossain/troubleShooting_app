<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Issues Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Issues Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Issues Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <a href="{{ route('issues.index') }}"  class="btn btn-warning mb-3">List</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Issues Create

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
        <form action="{{ route('issues.store') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <select class="form-select" id="user_id" name="user_id" required>
                    <option selected>Choose...</option>
                    @foreach($users as $user)    
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="user_id">User</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <select class="form-select" id="center_id" name="center_id" required>
                    <option selected>Choose...</option>
                    @foreach($centers as $center)    
                        <option value="{{ $center->id }}">{{ $center->name }} - {{ $center->city }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="center_id">Center</label>
                </div>
            </div>
            <div class="form-group">
                <label for="alarm">Alarm</label>
                <input type="text" class="form-control" id="alarm" aria-describedby="alarmHelp" name="alarm" required>
                <small id="alarmHelp" class="form-text text-muted">What was the alarm.</small>
            </div>
            <div class="form-group">
                <label for="occuring_time">Occuring Time</label>
                <input type="date" class="form-control" id="occuring_time" aria-describedby="occuring_time_help" name="occuring_time" required>
                <small id="occuring_time_help" class="form-text text-muted">What does it occured</small>
            </div>
            <div class="form-group">
                <label for="problem_history">Problem History</label>
                <input type="text" class="form-control" id="problem_history" aria-describedby="problem_history_help" name="problem_history" required>
                <small id="problem_history_help" class="form-text text-muted">What was the problem history</small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" aria-describedby="description_help" name="description" required>
                <small id="description_help" class="form-text text-muted">What description</small>
            </div>
            <div class="form-group">
                <label for="steps_taken">Steps Taken</label>
                <input type="text" class="form-control" id="steps_taken" aria-describedby="steps_taken_help" name="steps_taken" required>
                <small id="steps_taken_help" class="form-text text-muted">What was the steps taken</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>