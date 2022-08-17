<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Bids
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Bids of {{ $bids[0]->issue->code }} </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Bids</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('bids.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(isset($winners) && count($winners) > 0)
    <div class="w-50">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Winner
            </div>
            <div class="card-body text-center">
                <table class="table table-dark table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Score</th>
                            <th scope="col">Center</th>
                            <th scope="col">Assigned</th>                            
                            <th scope="col">Up For More</th>                            
                            <th scope="col">Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        @php $sl = 0; @endphp
                        @foreach($winners as $winner)
                            <tr>
                                <th scope="row">{{ ++$sl }}</th>
                                <td>{{ $winner->user->name }}</td>
                                <td>{{ $winner->score }}</td>
                                <td>{{ $winner->user->center->name }}</td>
                                <td>{{ $winner->assigned }}</td>
                                <td>{{ $winner->up_for_more == 1 ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('winners.assign', ['issue_id' => $winners[0]->issue_id, 'bid_id' => $winner->id]) }}" class="btn btn-primary">Assign</a>
                                </td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
                <a href="{{ route('winners.assign', ['issue_id' => $winners[0]->issue_id]) }}" class="btn btn-primary">Assign</a>
            </div>
        </div>
    </div>
    @endif

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Bids
        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>User</th>
                        <th>Center</th>
                        <th>Code</th>
                        <th>Score</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($bids as $bid)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $bid->user->name ?? '' }}</td>
                            <td>{{ $bid->user->center->name }}</td>
                            <td>{{ $bid->issue->code }}</td>
                            <td>{{ $bid->score }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('bids.delete', ['bid_id' => $bid->id]) }}" method="post">
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