<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Running Issues
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Running Issues </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Running Issues</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>    
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Running Issues

        </div>
        <div class="card-body">

        
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Uploaded By</th>
                        <th>Alarm</th>                        
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0 @endphp
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issue->uploaded_by->name ?? '' }}</td>
                            <td>{{ $issue->alarm ?? '' }}</td>
                            <td>{{ $issue->description ?? '' }}</td>
                            <td>
                                <form style="display:inline" action="{{ route('issues.delete', ['issue_id' => $issue->id]) }}" method="post">
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