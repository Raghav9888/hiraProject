@extends('layouts.app')

@section('content')
    <section class="featured-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="home-title">Practitioners</h1>
                </div>
                {{--                <div class="col-md-4">--}}
                {{--                    <select class="form-select" id="category" aria-label="Default select example"--}}
                {{--                            style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">--}}
                {{--                        <option class="selected-category">Select by Categories</option>--}}
                {{--                        @foreach($categories as $category)--}}
                {{--                            <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
                {{--                            <option>--}}
                {{--                                <hr>--}}
                {{--                            </option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}
            </div>

            <div class="row" id="practitionersList">
                @include('user.practitioner_list_xml_request')
            </div>
        </div>
        {{--        <div class="d-flex justify-content-center mt-2">--}}
        {{--            <button class="category-load-more">Load More</button>--}}
        {{--        </div>--}}
    </section>
@endsection
