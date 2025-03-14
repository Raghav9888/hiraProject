<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Admin Dashboard</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
               aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">User Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.users.new')}}">New Users</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
               aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Blogs Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.blogs.create')}}">Add Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.blogs.index')}}">All Blogs</a></li>
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
