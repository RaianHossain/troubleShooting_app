<x-backend.layouts.master>
    <x-slot name="pageTitle">
        My Uploaded
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> My Uploaded </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">My Uploaded</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    <a href="{{ route('issues.create') }}" class="btn btn-warning mb-3">Create New</a>
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-table me-1"></i>
            Issues

        </div>
        <div class="card-body">

        
            <table class="table table-bordered" id="uploadedTable">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Sl#</th>
                        <th>Alarm</th>                        
                        <th>Issue Code</th>                        
                        <th>Occuring Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issue->alarm ?? '' }}</td>
                            <td>{{ $issue->code ?? '' }}</td>
                            @php $date = \Carbon\Carbon::parse($issue->occuring_time) @endphp 
                            <td>{{ isset($date) == 1 ? $date->format('d-M-Y') : '' }}</td>
                            <td>
                                <a href="{{ route('issues.show', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-info">Show</a>
                                {{--<form style="display:inline" action="{{ route('issues.delete', ['issue_id' => $issue->id]) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#uploadedTable').DataTable();
        });
    </script>


</x-backend.layouts.master>