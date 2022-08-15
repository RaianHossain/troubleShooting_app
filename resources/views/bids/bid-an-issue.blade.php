<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Bids Create
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Bids Create </x-slot>

            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('bids.index') }}">Bids</a></li>
            <li class="breadcrumb-item active">Bids Create</li>

        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Bids Create

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
        <form action="{{ route('bids.bidStore') }}" method="post">
            @csrf
            
            {{--<div class="input-group mb-3">
                <select class="custom-select" id="issue_id" name="issue_id">
                    <option selected>Choose...</option>
                    @foreach($issues as $issue)    
                        <option value="{{ $issue->id }}">{{ $issue->code }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">Issue</label>
                </div>
            </div>--}}

            {{--<div class="input-group mb-3">
                <select class="custom-select" id="user_id" name="user_id">
                    <option selected>Choose...</option>
                    @foreach($users as $user)    
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="inputGroupSelect02">User</label>
                </div>
            </div>--}}

            <div class="form-group">
                <label for="issue_id">Issue</label>
                <select class="form-control" id="issue_id" aria-describedby="issue_idHelp" name="issue_id">
                    <option value="{{ $issue->id }}">{{ $issue->code }}</option>
                </select>
            </div>
            <br>

            <div class="form-group">
                <label for="timeToFix">Time To Fix</label>
                <input type="number" class="form-control" id="timeToFix" aria-describedby="timeToFixHelp" name="timeToFix">
            </div>
            <br>

            <div class="form-group">
                <label for="sendBackDate">Send Back Date</label>
                <input type="date" class="form-control" id="sendBackDate" aria-describedby="sendBackDateHelp" name="sendBackDate">
            </div>
            <br>

            <p>Need Support?</p>
            <div class="d-flex justify-content-between" style="width:10%">
                <div>
                    <input type="radio" id="yes" name="needSupport" value="1">
                    <label for="yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id="no" name="needSupport" value="0">
                    <label for="no">No</label>
                </div>
            </div>
            <br>

            <p>Need Spare?</p>
            <div class="d-flex justify-content-between" style="width:10%">
                <div>
                    <input type="radio" id="yes" name="needSpare" value="1">
                    <label for="yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id="no" name="needSpare" value="0">
                    <label for="no">No</label>
                </div>
            </div>
            <br>


            <div class="form-group">
                <label for="possibleCost">Possible Cost</label>
                <input type="number" class="form-control" id="possibleCost" aria-describedby="possibleCostHelp" name="possibleCost">
            </div>
            <br>

            <p>Have Existing Task:</p>
            <div class="d-flex justify-content-between" style="width:10%">
                <div>
                    <input type="radio" id="yes" name="haveExistingTask" value="1">
                    <label for="yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id="no" name="haveExistingTask" value="0">
                    <label for="no">No</label>
                </div>
            </div>
            <br>
          
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        </div>
    </div>

</x-backend.layouts.master>