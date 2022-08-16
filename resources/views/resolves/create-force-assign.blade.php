<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Force Assign
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Force assign of {{ $issue->code }} </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Resolves Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

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
                    <option value="{{ $issue->id }}">{{ $issue->code }}</option>                    
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
                <label for="start_date">Submission Date</label>
                <input type="date" class="form-control" id="submission_date" aria-describedby="submission_dateHelp" name="submission_date">
                <small id="submission_dateHelp" class="form-text text-muted">Submission Date.</small>
            </div> 

            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Show Bids
            </button>
        </form>
        
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bids Of {{ $issue->code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table table-dark table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Score</th>
                            <th scope="col">Center</th>
                            <th scope="col">Assigned</th>                            
                            <th scope="col">Up For More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl = 0; @endphp
                        @foreach($bids as $bid)
                            <tr>
                                <th scope="row">{{ ++$sl }}</th>
                                <td>{{ $bid->user->name }}</td>
                                <td>{{ $bid->score }}</td>
                                <td>{{ $bid->user->center->name }}</td>
                                <td>{{ $bid->assigned }}</td>
                                <td>{{ $bid->up_for_more == 1 ? 'Yes' : 'No' }}</td>
                                
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

</x-backend.layouts.master>