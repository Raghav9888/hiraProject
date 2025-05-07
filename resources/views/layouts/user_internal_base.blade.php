@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.user_sidebar')

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>
                        Welcome,<span style="color: #715549;"> {{ $user->first_name ?? 'User' }}  {{ $user->last_name ?? '' }}</span>
                    </h3>
                    <div>
{{--                        <img src="{{$user}}" class="rounded-circle" alt="Avatar">--}}
                    </div>
                </div>

            @yield('userContent')
            </main>



        </div>
    </div>

@endsection
