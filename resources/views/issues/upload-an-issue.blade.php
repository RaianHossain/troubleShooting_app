<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Issues Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Issues Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Issues Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Issues Create

        </div>
        <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('issues.uplaod') }}" method="post" enctype="multipart/form-data">
            @csrf            
            <div class="form-group">
                <label for="alarm">Alarm</label>
                <input type="text" class="form-control" id="alarm" aria-describedby="alarmHelp" name="alarm">
                <small id="alarmHelp" class="form-text text-muted">What was the alarm.</small>
            </div>
            <div class="form-group">
                <label for="occuring_time">Occuring Time</label>
                <input type="date" class="form-control" id="occuring_time" aria-describedby="occuring_time_help" name="occuring_time">
                <small id="occuring_time_help" class="form-text text-muted">What does it occured</small>
            </div>
            <div class="form-group">
                <label for="problem_history">Problem History</label>
                <input type="text" class="form-control" id="problem_history" aria-describedby="problem_history_help" name="problem_history">
                <small id="problem_history_help" class="form-text text-muted">What was the problem history</small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" aria-describedby="description_help" name="description">
                <small id="description_help" class="form-text text-muted">What description</small>
            </div>
            <div class="form-group">
                <label for="steps_taken">Steps Taken</label>
                <input type="text" class="form-control" id="steps_taken" aria-describedby="steps_taken_help" name="steps_taken">
                <small id="steps_taken_help" class="form-text text-muted">What was the steps taken</small>
            </div>
            <div class="form-group">
                <label for="imageOne" class="form-label">Picture One</label>
                <input class="form-control" type="file" id="imageOne" name="imageOne" aria-describedby="imageOnehelp">
                <small id="imageOnehelp" class="form-text text-muted">Upload a picture</small>
            </div>
            <div class="form-group">
                <label for="imageTwo" class="form-label">Picture Two</label>
                <input class="form-control" type="file" id="imageTwo" name="imageTwo" aria-describedby="imageTwohelp">
                <small id="imageTwohelp" class="form-text text-muted">Upload a picture</small>
            </div>
            <div class="form-group">
                <label for="imageThree" class="form-label">Picture</label>
                <input class="form-control" type="file" id="imageThree" name="imageThree" aria-describedby="imageThreehelp">
                <small id="imageThreehelp" class="form-text text-muted">Upload a picture</small>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
        </form>
        
        </div>
    </div>
<script>
    $('#submitButton').on('click', ()=>{
           fetch(`http://127.0.0.1:8000/sendEmail`).then(response=>console.log(response))
    });
</script>

</x-backend.layouts.master>
