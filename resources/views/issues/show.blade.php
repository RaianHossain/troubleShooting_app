<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Issue
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> {{ $issue->code }} </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Issue Details</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    
    
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between text-white" style="background-color: #0f4abf">
            <div>
                <i class="fa fa-exclamation-circle me-1"></i>
                Issues
            </div>
            <div>
                @php
                    $bidded = App\Models\Bid::where('issue_id', $issue->id)->where('user_id', auth()->user()->id)->first();
                @endphp
                @if(isset($bidded))
                <a href="#" class="btn px-5 btn-success">Bidded</a>  
                @else
                <a href="{{ route('bids.bidAnIssue', ['issue_id' => $issue->id]) }}" class="btn btn-warning px-5">Bid</a>  
                @endif
            </div>
        </div>
        <div class="card-body p-2">
            <div class="row bg-light g-0">
                <div class="col-md-6">
                    <div>
                        <img id="primary" src="{{ asset('Images/Issues/'.$issue->imageTwo) }}" alt="Image" style="width: 95%; height: 500px;">
                    </div>
                    <div class="d-flex mt-2">
                        <img id="secondaryOne" src="{{ asset('Images/Issues/'.$issue->imageOne) }}" alt="Image" style="width: 25%; height: 100px; margin-right: 5px;">
                        <img id="secondaryTwo" src="{{ asset('Images/Issues/'.$issue->imageThree) }}" alt="Image" style="width: 25%; height: 100px;">
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <h5><u>Alarm:</u> {{ $issue->alarm }}</h5>
                    <h5><u>Description:</u> {{ $issue->description }}</h5>
                    <h5><u>Occuring Time:</u> {{ $issue->occuring_time }}</h5>
                    <h5><u>Problem History:</u> {{ $issue->problem_history }}</h5>
                    <h5><u>Steps Taken:</u> {{ $issue->steps_taken }}</h5>
                    <h5><u>Solve Note:</u> {{ $issue->solve_note ?? '' }}</h5>
                </div>
            </div>            
        </div>
    </div>

    <script>
        $("#secondaryOne").on('click', () => {
            const thisImage = $("#secondaryOne").attr('src');
            const primaryImage = $("#primary").attr('src')
            $("#primary"). attr('src',thisImage);
            $("#secondaryOne"). attr('src',primaryImage);
        })

        $("#secondaryTwo").on('click', () => {
            const thisImage = $("#secondaryTwo").attr('src');
            const primaryImage = $("#primary").attr('src')
            $("#primary"). attr('src',thisImage);
            $("#secondaryTwo"). attr('src',primaryImage);
        })
    </script>

</x-backend.layouts.master>