<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container-fluid">
                <a href="{{route('home')}}">
                    <img class="header-logo" src="{{ url('./assets/images/header-logo.svg') }}" alt="header-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link parentLinks {{ request()->routeIs('partitionerLists') ? 'active' : '' }}" href="{{ route('partitionerLists') }}">DIRECTORY</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link parentLinks {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{route('blog')}}">ARTICLES & BLOGS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link parentLinks dropdown-toggle" href="#" id="settingsDropdown" role="button"
                               data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                COMPANY
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                                <li><a class="dropdown-item dropdownText" href="#">Press</a></li>
                                <li><a class="dropdown-item dropdownText" href="{{ route('contact') }}">Contact Us</a>
                                </li>
                                <li><a class="dropdown-item dropdownText" href="{{route('our_story')}}">Our Story</a></li>
                                <li><a class="dropdown-item dropdownText" href="{{route('our_vision')}}"> Our Vision</a></li>
                                <li><a class="dropdown-item dropdownText" href="{{route('core_values')}}"> Core Values</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-md-flex align-items-center justify-content-center">
                        @if(Auth::check())
                            <nav class="et-menu-nav">
                                <ul id="menu-practitioner-menu me-5" class="et-menu nav">
                                    @if((Auth::user()->role === 1 && Auth::user()->status === 1))
                                        <a href="{{ route('my_membership') }}" class="btn join-btn" type="submit"
                                           style="display: flex;align-items: center;justify-content: center">My Practitioner dashboard</a>
                                    @elseif((Auth::user()->role === 2 && Auth::user()->status === 1))
                                        <a href="{{ route('admin.dashboard') }}" class="btn join-btn" type="submit"
                                           style="display: flex;align-items: center; justify-content: center">My dashboard</a>
                                    @else
                                        <a href="{{ route('pendingUserRequest') }}" class="btn join-btn" type="submit"
                                           style="display: flex;align-items: center; justify-content: center">My Request</a>
                                    @endif

                                    {{--                                    <li id="menu-item-5395"--}}
                                    {{--                                        class="me-5 et_pb_menu_page_id-4726 menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-4726 current_page_item menu-item-5395">--}}
                                    {{--                                        <a href="{{route('myProfile')}}" aria-current="page"></a></li>--}}
                                </ul>
                            </nav>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="login-btn mt-2" type="submit">Logout</button>
                            </form>
                        @else
                            <a href="javascript:void(0)" data-bs-target="#exampleModal" data-bs-toggle="modal"
                               class="btn join-btn my-2 d-flex align-items-center justify-content-center">Join
                                as a
                                Practitioner</a>

                            <a href="{{ route('login') }}"
                               class="btn login-btn my-2  d-flex align-items-center justify-content-center"
                               type="submit">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
