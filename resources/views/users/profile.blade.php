<x-backend.layouts.master>
    <x-slot name="pageTitle">
    Profile - {{$user->name }}
    </x-slot>
    <div class="m-5 d-flex justify-content-end">
        <input type="hidden" id="base_url" value="{{ url('') }}">
        <input type="hidden" id="user_id" value="{{ $user->id }}">

        <div class="form-check form-switch">
            <label  for="flexSwitchCheckDefault">Up for more work</label>
            <input class="form-check-input" type="checkbox" id="up_for_more" {{ $user->up_for_more == 1 ? 'checked' : '' }}>
        </div>
    </div>
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

    <script>
        $('#up_for_more').on('click', () => {
            const base_url = $("#base_url").val();
            const user_id = $("#user_id").val();
            if($("#up_for_more").is(':checked')){
                fetch(base_url+`/api/up-for-more/${user_id}/yes`)
            }
            else{
                fetch(base_url+`/api/up-for-more/${user_id}/no`)
            }
        })
    </script>   
 
</x-backend.layouts.master>