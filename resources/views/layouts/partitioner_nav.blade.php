
<div class="row">
    <div class="col-2 d-block d-lg-none">
        <button class="navbar-toggler collapsed fs-1" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <div class="col-10">
        <h5 style="text-transform: capitalize;" class="home-title mb-5">
            Welcome,<span
                style="color: #715549;"> {{ $user->first_name ?? 'User' }}  {{ $user->last_name ?? '' }}</span>
        </h5>
    </div>
</div>

<div class="col-sm-12 col-lg-10">
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
        @php
            $allowedName = [
            'Daverine Jumu' => [
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '30 minutes', 'price' => 40, 'description' => 'Mini Guidance Session'],
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '60 minutes', 'price' => 80, 'description' => 'Mini Guidance Session w/ Energy Work'],
                ['name' => 'Inner Guidance Sessions and Oracle Readings', 'duration' => '20 minutes', 'price' => 25, 'description' => 'Mini Oracle Reading'],
            ],
            'Brigitta Ziemba' => [
                ['name' => 'Quantum Healing/CST', 'duration' => '30 minutes', 'price' => 60, 'description' => 'Mini CranioSacral Therap/Quantum Healing Sessions (nervous system resets)'],
            ],
            'Julie Brar' => null,
            'Maria Esposito' => [
                ['name' => 'Intuitive numerology reading', 'duration' => '20 minutes', 'price' => 42, 'description' => 'intuitive numerology reading'],
                ['name' => 'Intuitive numerology reading', 'duration' => '40 minutes', 'price' => 78, 'description' => 'intuitive numerology reading'],
                ['name' => 'Intuitive Numerology readings', 'duration' => '60 minutes', 'price' => 117, 'description' => 'intuitive numerology reading'],
            ],
            'Anna i. Azucena' => null,
            'Shelley King' => [
                ['name' => 'Readings (Tarot, Lenormand, Crystal)', 'duration' => '20 minutes', 'price' => 40, 'description' => 'Reading'],
            ],
            'Lauren Welchner' => [
                ['name' => 'Mini tarot readings', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Mini tarot readings'],
                ['name' => 'Mini tarot readings', 'duration' => '30 minutes', 'price' => 55, 'description' => 'Mini tarot readings'],
            ],
            'Jothi Saldanha' => [
                ['name' => 'Somatic wellness sessions', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Mini Somatic Touch, Movement, and Breathwork Session'],
            ],
            'Isabel Nantaba' => [
                ['name' => 'Mini energy shift sessions', 'duration' => '20 minutes', 'price' => 55, 'description' => 'Energy Healing Session'],
            ],
            'Janine Berridge-Paul' => [
                ['name' => 'Mini reiki session (will include a crystal)', 'duration' => '20 minutes', 'price' => 55, 'description' => 'Mini reiki session'],
            ],
            'Melissa Charles' => [
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '5 minutes', 'price' => 15, 'description' => 'Mini Tarot Sessions and Bone Diviniation'],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '15 minutes', 'price' => 50, 'description' => 'General or Specific Question'],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '15 minutes', 'price' => 30, 'description' => 'Bone/Charm Divination '],
                ['name' => 'Mini Tarot Sessions and Bone Diviniation', 'duration' => '1 hour', 'price' => 80, 'description' => 'Deep-Dive'],
            ],
            'Malavika' => null,
            'Biohacking' => null,
            'Intuitive' => null,
            'TEST PRACTITIONER' => null,
            'Mohit Verma' => null,

        ];
            $allowedNames = array_keys($allowedName);
        @endphp

        @if (in_array($user->name, $allowedNames))
            <li class="{{ Route::currentRouteName() === 'practitionerShows' ? 'active' : '' }}">
                <a href="{{ route('practitionerShows') }}">
                    Shows
                </a>
            </li>
        @endif


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

