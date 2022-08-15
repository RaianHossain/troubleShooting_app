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
    
    <div class="w-100 d-flex d-flex align-items-center justify-content-center" style="height: 400px;">
        <h1 class="text-danger">You are not resolving anything now...!</h1>
    </div>
    
    
</x-backend.layouts.master>