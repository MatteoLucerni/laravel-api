@if (session('alert-message'))
    <div class="mt-5 alert alert-{{ session('alert-type') }}">
        {{ session('alert-message') }}
    </div>
@endif
