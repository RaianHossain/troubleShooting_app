<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Resolving Now
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Resolves </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Resolving Now</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
    <div class="mb-3">
        <div>
            <div class="d-flex justify-content-between">
                <div>
                    <p>
                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#requestCollapse" aria-expanded="false" aria-controls="collapseExample">
                            Extend Request
                        </button>  

                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#giveUpCollapse" aria-expanded="false" aria-controls="collapseExample">
                            Give Up
                        </button>

                        {{--<a href="{{ route('resolves.giveup', ['resolve_id' => $resolvingNow->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Give Up</a>--}}
            
                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#completeCollapse" aria-expanded="false" aria-controls="collapseExample">
                            Complete
                        </button>                        
                    </p>
                </div>
                <div>
                @if(isset($requests) && count($requests) > 0)
                <div>
                    @php $counter = 1; @endphp
                    @foreach($requests as $request)            
                        <span class="{{ $request->approved == 1 ? 'badge bg-success' : 'badge bg-warning' }}">Request-{{ $counter }}: {{ $request->approved == 1 ? "Approved" : "Pending" }}</span>
                    @endforeach
                </div>
                @endif
                </div>
            </div>            
    
            <div class="collapse" id="requestCollapse">
                <div class="card card-body">
                    <form action="{{ route('resolves.extendRequest') }}" method="post">
                        @csrf 
                        <input type="hidden" name="resolve_id" value="{{ $resolvingNow->id }}">
                        <textarea name="reason" id="reason" cols="30" rows="5" class="w-100"></textarea>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-success mt-3" style="width: 10%;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="collapse" id="giveUpCollapse">
                <div class="card card-body">
                    <form action="{{ route('resolves.giveup') }}" method="post">
                        @csrf 
                        <input type="hidden" name="resolve_id" value="{{ $resolvingNow->id }}">
                        <textarea name="previous_resolve_note" id="previous_resolve_note" cols="30" rows="5" class="w-100"></textarea>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-success mt-3" style="width: 10%;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
    
            <div class="collapse" id="completeCollapse">
                <div class="card card-body">
                    <form action="{{ route('resolves.complete') }}" method="post">
                        @csrf 
                        <input type="hidden" name="resolve_id" value="{{ $resolvingNow->id }}">
                        <textarea name="solveNote" id="solveNote" cols="30" rows="5" class="w-100"></textarea>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-success mt-3" style="width: 10%;">Finish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="bg-dark p-3">
        <div class="d-flex justify-content-between bg-white p-3 mb-3">
            <h5>Start Date: {{ $resolvingNow->received_date ? $resolvingNow->received_date->format('d-M-Y') : '' }}</h5>
            <h5 id="counting">Waiting</h5>
            <h5>End Date: {{ $resolvingNow->submission_date ? $resolvingNow->submission_date->format('d-M-Y') : '' }}</h5>
            <input type="hidden" id="sub_date" value="{{ $resolvingNow->submission_date ?? null }}">
        </div>

        <div class="row g-0">
            <div class="col-md-5">
                <div style="width: 98%;">
                    <img src="{{ $resolvingNow->issue->imageOne ? asset('Images/Issues/'.$resolvingNow->issue->imageOne) : '' }}" alt="" style="width: 100%; height: 400px;">
                </div>

                <div class="d-flex">
                    <img src="{{ $resolvingNow->issue->imageTwo ? asset('Images/Issues/'.$resolvingNow->issue->imageTwo) : '' }}" alt="" style="width: 15%; height: 100px; margin-right: 5px">

                    <img src="{{ $resolvingNow->issue->imageThree ? asset('Images/Issues/'.$resolvingNow->issue->imageThree) : '' }}" alt="" style="width: 15%; height: 100px;">
                </div>
            </div>
            <div class="col-md-7 bg-white p-3" style="overflow: hidden;">
                <h5><u>Code:</u> {{ $resolvingNow->issue->code }}</h5>
                <h5><u>Alarm:</u> {{ $resolvingNow->issue->alarm }}</h5>
                <h5><u>Description:</u> {{ $resolvingNow->issue->description }}</h5>
                <h5><u>Occuring Time:</u> {{ $resolvingNow->issue->occuring_time }}</h5>
                <h5><u>Problem History:</u> {{ $resolvingNow->issue->problem_history }}</h5>
                <h5><u>Steps Taken:</u> {{ $resolvingNow->issue->steps_taken }}</h5>
                <h5><u>Previous Solve Note:</u> {{ $resolvingNow->previous_resolve_note ?? 'No solve note' }}</h5>
                <h4 class="bg-warning p-2 w-75"><u>Shipped Date:</u> {{ $resolvingNow->shipped_date ?? 'No yet shipped' }}</h4>
                @if($resolvingNow->shipped_date)
                @if($resolvingNow->received_date)
                <h4 class="bg-warning p-2 w-75"><u>Received Date:</u> {{ $resolvingNow->received_date }}</h4>
                @else
                <div>
                    <h4 class="bg-warning p-2 w-75"><u>Received Date:</u></h4>
                    <a href="{{ route('resolves.receive', ['resolve_id' => $resolvingNow->id]) }}" class="btn btn-primary" onclick="return confirm('Are you sure?')">Receive</a>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>   
    
    @if($resolvingNow->submission_date && $resolvingNow->received_date)
    <script>
        var submission_date = "<?php echo $resolvingNow->submission_date->format('M d, Y H:i:s'); ?>";
        // var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();
        var countDownDate = new Date(submission_date).getTime();


        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("counting").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("counting").innerHTML = "EXPIRED";
        }
        }, 1000);              
    </script>
    @endif
    
</x-backend.layouts.master>