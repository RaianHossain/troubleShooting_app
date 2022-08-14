<x-backend.layouts.master>
    <x-slot name="pageTitle">
    Profile - {{$user->name }}
    </x-slot>
    <div class="row m-5">
    <div class="col-md-4 text-center border bg-light">
            <img src="https://www.blackswandesigns.co/wp-content/uploads/bfi_thumb/female-avatar-profile-picture-vector-female-avatar-profile-picture-vector-102690279-pgvgl0nwkupdn1k5hx6lcjng11hx6jsd77q7tm0sgc.jpg" alt="something went wrong">
            <h1 > {{ $user->name }} </h1>
        </div>
        <div class="col-md-8 border bg-light">
        
        <div  class="mt-5">
            <h4> <strong>Email:</strong>  {{ $user->email }} </h4>
            <h4> <strong>Center:</strong>  {{ $user->center->name }} </h4>
            <h4> <strong>Total Issue Solved : </strong> {{ count($resolves) }} </h4>
        </div>
</div>
        
    </div>
   
 
</x-backend.layouts.master>