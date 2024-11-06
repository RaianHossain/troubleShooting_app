<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Assigned Issues
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Assigned Issues </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Assigned Issues</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @if($issues[0])
        <script>            
            const issueUploadedFrom = "<?php echo $issues[0]->user->center->name; ?>";
            const issueCode = "<?php echo $issues[0]->code; ?>";
            const assignedTo = "<?php echo $issues[0]->to->name; ?>";
            const base_url = "<?php echo $base_url; ?>";
            const data = {                
                'subscriber': 'all',
                'message' : `Issue from ${issueUploadedFrom} code: ${issueCode} has been assigned to ${assignedTo}`,
                'url' : `${base_url}/issues/assigned`
            }

            fetch(base_url+'/api/make-notification', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    "Content-type": "application/json; charset=UTF-8"
                }
            })
        </script>
        @endif
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Pending Issues

        </div>
        <div class="card-body">

        
            <table class="table table-bordered" id="assignedIssueTable">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Uploaded By</th>
                        <th>Code</th>
                        <th>Uploaded From</th>
                        <th>Alarm</th>                        
                        <th>To</th>
                        <th>To Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0; @endphp
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issue->user->name ?? '' }}</td>
                            <td>{{ $issue->code ?? '' }}</td>
                            <td>{{ $issue->user->center->name ?? '' }}</td>
                            <td>{{ $issue->alarm ?? '' }}</td>
                            <td>{{ $issue->to->name ?? '' }}</td>
                            <td>{{ $issue->to->center->name ?? '' }}</td>
                            <td>
                                <a href="{{ route('issues.show', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('bids.index', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-warning">Show Bids</a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#assignedIssueTable').DataTable();
        });
    </script>

</x-backend.layouts.master>