@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.nav')

    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Waitlist Details</h4>

                        <div class="mb-3"><strong>Full Name:</strong> {{ $waitlist?->first_name }} {{ $waitlist?->last_name }}</div>
                        <div class="mb-3"><strong>Email:</strong> {{ $waitlist?->email }}</div>
                        <div class="mb-3"><strong>Phone:</strong> {{ $waitlist?->phone }}</div>
                        <div class="mb-3"><strong>Business Name:</strong> {{ $waitlist?->business_name }}</div>
                        <div class="mb-3"><strong>Website:</strong> <a href="{{ $waitlist?->website }}" target="_blank">{{ $waitlist?->website }}</a></div>
                        <div class="mb-3"><strong>Current Practice:</strong><br>{{ $waitlist?->current_practice }}</div>

                        <div class="mb-3">
                            <strong>Heard From:</strong>
                            @if(is_array($waitlist->heard_from))
                                <ul>
                                    @foreach ($waitlist->heard_from as $source)
                                        <li>{{ $source }}</li>
                                    @endforeach
                                </ul>
                            @else
                                {{ $waitlist->heard_from }}
                            @endif
                        </div>

                        <div class="mb-3"><strong>Referral Name:</strong> {{ $waitlist->referral_name }}</div>
                        <div class="mb-3"><strong>Other Source:</strong> {{ $waitlist->other_source }}</div>
                        <div class="mb-3"><strong>Called to Join:</strong> {{ $waitlist->called_to_join }}</div>
                        <div class="mb-3"><strong>Practice Values:</strong><br>{{ $waitlist->practice_values }}</div>
                        <div class="mb-3"><strong>Excitement About Hira:</strong><br>{{ $waitlist->excitement_about_hira }}</div>
                        <div class="mb-3"><strong>Call Availability:</strong> {{ $waitlist->call_availability }}</div>
                        <div class="mb-3"><strong>Newsletter:</strong> {{ $waitlist->newsletter }}</div>

                        @if(is_array($waitlist->uploads) && count($waitlist->uploads))

                            <div class="mb-3">
                                <strong>Uploads:</strong>
                                <ul>
                                    @foreach ($waitlist->uploads as $file)
                                            <?php
                                            $imageUrl = asset(env('media_path') . '/admin/blog/' . $file);
                                            ?>
                                        <li>
                                            <a href="{{ asset(env('media_path') .'/' . $file) }}" target="_blank">View File</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3 text-muted">
                            <small><strong>Submitted At:</strong> {{ $waitlist->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
