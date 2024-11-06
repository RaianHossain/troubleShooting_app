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
    @endif
        
    <table class="table table-bordered" id="issuesForBid">
        <thead class="text-white" style="background-color: #0f4abf">
            <tr>
                <th>Sl#</th>
                <th>Uploaded By</th>
                <th>Alarm</th>  
                <th>Code</th>                      
                <th>Description</th>
                <th style="width: 5%;">Action</th>
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
                    <td style="width: 130px;">
                        <a href="{{ route('issues.show', ['issue_id' => $issue->id]) }}" class="btn btn-sm btn-info">Show</a>
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

    <script>
        $(document).ready(function () {
            $('#issuesForBid').DataTable();
        });
    </script>

   


</x-backend.layouts.master>