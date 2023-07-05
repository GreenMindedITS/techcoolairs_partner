<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }} ">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item mt-2">
    <a href="{{ route('profile') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'profile' ? 'active' : '' }} ">
        <i class="nav-icon fas fa-user"></i>
        <p>Profile</p>
    </a>
</li>
<li class="nav-item mt-2 {{ (Route::currentRouteName() === 'services' || Route::currentRouteName() === 'schedule_services') ? 'menu-open' : '' }}">
    <a href="" class="nav-link {{ (Route::currentRouteName() === 'services' || Route::currentRouteName() === 'schedule_services') ? 'active' : '' }}">
        <i class="nav-icon fas fa-fan"></i>
        <p>
            Services
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    </a>
    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() === 'services' || Route::currentRouteName() === 'schedule_services') ? 'display:block;' : 'display:none;' }}"> 
        <li class="nav-item">
            <a href="{{ route('services') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'services' ? 'active' : '' }} ">
                <i class="{{ Route::currentRouteName() === 'services' ? 'fas fa-circle' : 'far fa-circle' }} nav-icon"></i>
                <p>Add Services</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('schedule_services') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'schedule_services' ? 'active' : '' }} ">
                <i class="{{ Route::currentRouteName() === 'schedule_services' ? 'fas fa-circle' : 'far fa-circle' }} nav-icon"></i>
                <p>Schedule Services</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item mt-2">
    <a href="{{ route('job_order') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'job_order' ? 'active' : '' }} ">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Job Order</p>
    </a>
</li>
<li class="nav-item mt-2">
    <a href="{{ route('technicians') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'technicians' ? 'active' : '' }} ">
        <i class="nav-icon fas fa-tools"></i>
        <p>Technicians</p>
    </a>
</li>
<li class="nav-item mt-2">
    <a href="{{ route('activities') }}" class="nav-link pt-3 pb-3 {{ Route::currentRouteName() === 'activities' ? 'active' : '' }} ">
        <i class="nav-icon fas fa-bell"></i>
        <p>Activities</p>
    </a>
</li>