<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Admin Dashboard</li>
        <li class="nav-item {{request()->routeIs('admin.users.*')? 'active': ''}} ">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
               aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">User Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.user.*')? 'show': ''}}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route('userType') == 'practitioner' ? 'active' : '' }}"
                           href="{{ route('admin.user.index', ['userType' => 'practitioner']) }}">Practitioner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route('userType') == 'client' ? 'active' : '' }}"
                           href="{{ route('admin.user.index', ['userType' => 'client']) }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route('userType') == 'new' ? 'active' : '' }}"
                           href="{{ route('admin.user.index', ['userType' => 'new']) }}">New Practitioner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route('userType') == 'delete' ? 'active' : '' }}"
                           href="{{ route('admin.user.index', ['userType' => 'delete']) }}">Delete Practitioner</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->routeIs('admin.offering.*')? 'active': ''}} ">
            <a class="nav-link" data-bs-toggle="collapse" href="#offering" aria-expanded="false"
               aria-controls="plan">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Event Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.offering.*')? 'show': ''}}" id="offering">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link plans {{request()->routeIs('admin.offering.create')? 'active': ''}}" href="{{route('admin.offering.create')}}">Add Event</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.offering.index')? 'active': ''}}" href="{{route('admin.offering.index')}}">All Events</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->routeIs('admin.plans.*')? 'active': ''}} ">
            <a class="nav-link" data-bs-toggle="collapse" href="#plan" aria-expanded="false"
               aria-controls="plan">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Plan Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.plans.*')? 'show': ''}}" id="plan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link plans {{request()->routeIs('admin.plans.create')? 'active': ''}}" href="{{route('admin.plans.create')}}">Add New</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.plans.index')? 'active': ''}}" href="{{route('admin.plans.index')}}">All Plans</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->routeIs('admin.blogs.*')? 'active': ''}}">
            <a class="nav-link" data-bs-toggle="collapse" href="#blog-elements" aria-expanded="false"
               aria-controls="blog-elements">
                <i class="menu-icon mdi mdi-post-outline"></i>
                <span class="menu-title">Blog Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.blogs.*')? 'show': ''}}" id="blog-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link blog {{request()->routeIs('admin.blogs.create')? 'active': ''}}" href="{{route('admin.blogs.create')}}">Add Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.blogs.index')? 'active': ''}}" href="{{route('admin.blogs.index')}}">All Blogs</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{request()->routeIs('admin.location.*')? 'active': ''}}">
            <a class="nav-link" data-bs-toggle="collapse" href="#location-elements" aria-expanded="false"
               aria-controls="blog-elements">
                <i class="menu-icon mdi mdi-map-marker-multiple"></i>
                <span class="menu-title">Location Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.location.*')? 'show': ''}}" id="location-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link location{{request()->routeIs('admin.location.create')? 'active': ''}}" href="{{route('admin.location.create')}}">Add Location</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.location.index')? 'active': ''}}" href="{{route('admin.location.index')}}">All Locations</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->routeIs('admin.category.*')? 'active': ''}}">
            <a class="nav-link" data-bs-toggle="collapse" href="#category-elements" aria-expanded="false"
               aria-controls="blog-elements">
                <i class="menu-icon mdi mdi-shape"></i>
                <span class="menu-title">Category Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.category.*')? 'show': ''}}" id="category-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link category {{request()->routeIs('admin.category.create')? 'active': ''}}" href="{{route('admin.category.create')}}">Add Category</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.category.index')? 'active': ''}}" href="{{route('admin.category.index')}}">All Categories</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->routeIs('admin.feedback.*')? 'active': ''}}">
            <a class="nav-link" data-bs-toggle="collapse" href="#feedback-elements" aria-expanded="false"
               aria-controls="feedback-elements">
                <i class="menu-icon mdi mdi-message-alert"></i>
                <span class="menu-title">Feedback Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.feedback.*')? 'show': ''}}" id="feedback-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link location{{request()->routeIs('admin.feedback.create')? 'active': ''}}" href="{{route('admin.feedback.create')}}">Add Feedback</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.feedback.index')? 'active': ''}}" href="{{route('admin.feedback.index')}}">All feedbacks</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{request()->routeIs('admin.community.*')? 'active': ''}}">
            <a class="nav-link" data-bs-toggle="collapse" href="#community-elements" aria-expanded="false"
               aria-controls="blog-elements">
                <i class="menu-icon mdi mdi-account-group"></i>
                <span class="menu-title">Community Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{request()->routeIs('admin.community.*')? 'show': ''}}" id="community-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link location{{request()->routeIs('admin.community.create')? 'active': ''}}" href="{{route('admin.community.create')}}">Add Community Message</a></li>
                    <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.community.index')? 'active': ''}}" href="{{route('admin.community.index')}}">All Community Messages</a></li>
                </ul>
            </div>
        </li>

        {{--            <li class="nav-item">--}}
        {{--              <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">--}}
        {{--                <i class="menu-icon mdi mdi-chart-line"></i>--}}
        {{--                <span class="menu-title">Charts</span>--}}
        {{--                <i class="menu-arrow"></i>--}}
        {{--              </a>--}}
        {{--              <div class="collapse" id="charts">--}}
        {{--                <ul class="nav flex-column sub-menu">--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>--}}
        {{--                </ul>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="nav-item">--}}
        {{--              <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">--}}
        {{--                <i class="menu-icon mdi mdi-table"></i>--}}
        {{--                <span class="menu-title">Tables</span>--}}
        {{--                <i class="menu-arrow"></i>--}}
        {{--              </a>--}}
        {{--              <div class="collapse" id="tables">--}}
        {{--                <ul class="nav flex-column sub-menu">--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>--}}
        {{--                </ul>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="nav-item">--}}
        {{--              <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">--}}
        {{--                <i class="menu-icon mdi mdi-layers-outline"></i>--}}
        {{--                <span class="menu-title">Icons</span>--}}
        {{--                <i class="menu-arrow"></i>--}}
        {{--              </a>--}}
        {{--              <div class="collapse" id="icons">--}}
        {{--                <ul class="nav flex-column sub-menu">--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a></li>--}}
        {{--                </ul>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="nav-item">--}}
        {{--              <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">--}}
        {{--                <i class="menu-icon mdi mdi-account-circle-outline"></i>--}}
        {{--                <span class="menu-title">User Pages</span>--}}
        {{--                <i class="menu-arrow"></i>--}}
        {{--              </a>--}}
        {{--              <div class="collapse" id="auth">--}}
        {{--                <ul class="nav flex-column sub-menu">--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>--}}
        {{--                  <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>--}}
        {{--                </ul>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="nav-item">--}}
        {{--              <a class="nav-link" href="docs/documentation.html">--}}
        {{--                <i class="menu-icon mdi mdi-file-document"></i>--}}
        {{--                <span class="menu-title">Documentation</span>--}}
        {{--              </a>--}}
        {{--            </li>--}}
    </ul>
</nav>
