<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Issues You Can Bid
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Issues For Bid </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Issues For Bid</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>    
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>

        @if(isset($issues[0]) && session()->get('message') == 'Successfully uploaded')
        <script>
            const issueUploader = "<?php echo $issues[0]->user->name; ?>";
            const issueUploadedFrom = "<?php echo $issues[0]->user->center->name; ?>";
            const issueId = "<?php echo $issues[0]->id; ?>";
            const base_url = "<?php echo $base_url; ?>";
            const data = {
                'subscriber': 'all',
                'message' : `A new issue has been uploaded by ${issueUploader} from ${issueUploadedFrom}`,
                'url' : `${base_url}/show/${issueId}`
            }

            fetch(base_url+'/api/make-notification', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    "Content-type": "application/json; charset=UTF-8"
                }
            })
        </script>

        <script>
            $('#submitButton').on('click', ()=>{
                fetch(`http://127.0.0.1:8000/sendEmail`).then(response=>console.log(response))
            });
        </script>
       
        @endif
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Issues You Can Bid

        </div>
        <div class="card-body">

        
            <table class="table table-bordered" id="issuesForBid">
                <thead>
                    <tr>
                        <th>Sl#</th>
                        <th>Uploaded By</th>
                        <th>Alarm</th>  
                        <th>Code</th>                      
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sl = 0; @endphp
                    @foreach($issues as $issue)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $issue->user->name ?? '' }}</td>
                            <td>{{ $issue->alarm ?? '' }}</td>
                            <td>{{ $issue->code ?? '' }}</td>
                            <td style="width: 370px;">{{ $issue->description ?? '' }}</td>
                            <td>
                                <a href="{{ route('issues.show', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-warning">Show</a>
                                @php
                                    $bidded = App\Models\Bid::where('issue_id', $issue->id)->where('user_id', auth()->user()->id)->first();
                                @endphp
                                @if(isset($bidded))
                                <a href="#" class="btn btn-sm btn-success">Bidded</a>  
                                @else
                                <a href="{{ route('bids.bidAnIssue', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-warning">Bid</a>  
                                @endif                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#issuesForBid').DataTable();
        });
    </script>

   


</x-backend.layouts.master>