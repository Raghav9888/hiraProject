@extends('layouts.app')
@section('content')
    <div class="blog-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="blog-detail-left-dv">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="{{route('blog')}}" class="blog-view-more"><i
                                    class="fa-solid fa-chevron-left me-2"></i>Back</a>
                            {{-- <div class="search-container location-input">
                                <input type="text" class="search-input" placeholder="Search Articles, Blogs and Videos">
                                <button class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="blog-search-btn">Search</button>
                            </div> --}}
                        </div>
                        <div class="blog-detail-banner" style="background-image: url('{{ asset(env('media_path') . '/admin/blog/' . $blog->image) }}');">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <button class="mb-3">{{@$blog->category->name}}</button>
                                <div style="display: flex; gap: 15px;" >
                                    <h6><i class="fa-regular fa-heart me-2"></i>Favourites</h6>
                                    <h6><i class="fa-solid fa-share-nodes me-2"></i>Share</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <p class="m-0 mb-3">Published on <span>{{date('M d, Y', strtotime($blog->date))}}</span></p>
                                <p class="m-0">Published by The <span>{{@$blog->author}}</span></p>
                            </div>
                        </div>
                        <h2>{{$blog->name}}</h2>
                        <div class="blog-description">
                            {!! $blog->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
