<div class="row">
    <div class="col-2 d-block d-lg-none">
        <button class="navbar-toggler collapsed fs-1" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <div class="col-10">
        <h5 style="text-transform: capitalize;" class="home-title mb-5">
            Welcome,<span style="color: #715549;"> {{ $user->first_name ?? 'User' }}  {{ $user->last_name ?? '' }}</span>
        </h5>
    </div>
</div>

<div class="col-sm-12 col-lg-9">
    <ul class="practitioner-profile-btns navbar">
        <li class="{{ Request::is('my-profile') ? 'active' : '' }}">
            <a href="{{ route('my_profile') }}">
                My Profile
            </a>
        </li>
        <li class="offering {{ Request::is('offering') ? 'active' : '' }} {{ Request::is('discount') ? 'active' : '' }}">
            <a href="{{ route('offering') }}">
                Offerings
            </a>
        </li>
        <li class="{{ Request::is('appointment') ? 'active' : '' }}">
            <a href="{{ route('appointment') }}">
                Appointments
            </a>
        </li>
        <li class="{{ Request::is('calendar') ? 'active' : '' }}">
            <a href="{{ route('calendar') }}">
                Calendar
            </a>
        </li>
        <li class="offering {{ Request::is('accounting') ? 'active' : '' }}">
            <a href="{{ route('accounting') }}">
                Accounting
            </a>
        </li>
    </ul>
</div>

