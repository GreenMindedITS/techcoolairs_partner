<div class="sidebar">
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ (Auth::user()->image != null) ? 
                asset('/profile_images/'.Auth::user()->image) : asset('/img/img_avatar.png') }}" class="img-circle elevation-2" alt="User Image" style="height:2.1rem;">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div> --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            @include('layouts.menu')
        </ul>
    </nav>
</div>
