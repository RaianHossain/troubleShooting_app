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
                        <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#requestCollapse" aria-expanded="false" aria-controls="collapseExample">
                            Extend Request
                        </button>  
            
                        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#completeCollapse" aria-expanded="false" aria-controls="collapseExample">
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
                            <button type="submit" class="btn btn-sm btn-info mt-3" style="width: 10%;">Submit</button>
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
                            <button type="submit" class="btn btn-sm btn-info mt-3" style="width: 10%;">Finish</button>
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
    @if(isset($resolvingNow))
    <div class="bg-secondary p-3">
        <div class="d-flex justify-content-between bg-light p-3 mb-3">
            <h5>Start Date: {{ $resolvingNow->created_at->format('d-M-Y') }}</h5>
            <h5 id="counting">Counting</h5>
            <h5>End Date: {{ $resolvingNow->submission_date->format('d-M-Y') }}</h5>
        </div>

        <div class="row g-0">
            <div class="col-md-5">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAElBMVEXy8vL////6+vr19fX4+Pj8/Px/aeudAAACoklEQVR4nO3c227bMBBF0cgk//+XGwu6kRxeRnFaVGevt8a2AG3QQ0kN8vUFAAAAAAAAAAAAAAAAAAAAAACAv2j5Ba9/fVK/hVgOxHL4Prf0+qD08FgfPbfw8Fjpk8cjlgOxHIjlQCwHYjlIxgoh3DqeXqyQbl+Ky8VK551L9B5PLFb40X2eWKyf3RVrxUpFrMU36KVihbKV88pCKtarfjzlWlpSsepWvh1RPZbr3JVi1SPLObSUYlkri1g7ZpZDGau6zGI3PJWxjKHV+3gqv6NSsXxX8KkqoxWrXFq98R7rkaYVq6jVaxWMpScWK6vVPW9rqKnF2r5e71e6G6G5+vRifZ9zjHFwyZDM9acYayx7PHEOeWIZ4pI5ViGxatW16/UFYlUfsy/HiFUx7iC3oxCrZDx73oc8sQrRarUNeWLlrKepx5AnVqbZaq0lHytmd3/tVu8jqccK2VuMjfA65NVjLdf3mBvhKYjHStuaWTU2wkst6Vj71+64MBiTjXV+7cL2dmK1XJdS+W9i5bI2qfoJsYpXy1rDEa8aq7ymitYPibWqr6nWIT+spRjL+sJNbYmCsexR3n5FOpYdYmZL1IvVmkxrif6WKBerPcXHW6JarN7SGW6JYrH6Q2m0JYrF6rYabolasQatRluiVKzJG5rmXFOKNXhyvOpuiUKxJh4rLP0tUSfW3JPj7ddm1GNNtuptiTKxxsN9194SVWLNDPesifUBkVhzw33X2hI1Ys0O911jS9SI5WzVukuUiDU/3A/vj1XrUSHWjVb2/44JxPJshEWYl/GzJzpieYf7ztgSHx/rbitrS3x8rDsDa7MeJ+0UYn2K9i+zOT09Fn8ueNbCH6Ked3+utxGLWMQCAAAAAAAAAAAAAAAAAAAAAAD4//0BUyATTom0AxcAAAAASUVORK5CYII=" alt="" style="width: 98%; height: 400px;">
            </div>
            <div class="col-md-7 bg-light p-3" style="overflow: hidden;">
                <h5><u>Alarm:</u> {{ $resolvingNow->issue->alarm }}</h5>
                <h5><u>Description:</u> {{ $resolvingNow->issue->description }}</h5>
                <h5><u>Occuring Time:</u> {{ $resolvingNow->issue->occuring_time }}</h5>
                <h5><u>Problem History:</u> {{ $resolvingNow->issue->problem_history }}</h5>
                <h5><u>Steps Taken:</u> {{ $resolvingNow->issue->steps_taken }}</h5>
                
            </div>
        </div>
    </div>
    @else
    <h2>You are not resolving anything now.</h2>
    @endif
    
    <script>
        // $("#counting").on("click", ()=> {alert("just check")});
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
    
</x-backend.layouts.master>