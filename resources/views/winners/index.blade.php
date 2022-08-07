<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Winners
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Winners </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Winners</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('winners.create') }}" class="btn btn-warning mb-3">Create New</a>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Winners

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Issue</th>
                        <th>Bidder</th>
                        <th>Score</th>
                        <th>Extension Count</th>
                        <th>Extended Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($winners as $winner)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $winner->issue->alarm ?? '' }}</td>
                            <td>{{ $winner->bid->user->name ?? '' }}</td>
                            <td>{{ $winner->bid->score ?? '' }}</td>
                            <td>{{ $winner->extensionCount ?? '' }}</td>
                            <td>{{ $winner->extended_date ?? '' }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('winners.delete', ['winner_id' => $winner->id]) }}" method="post">
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