<header id="topnav" class="defaultscroll sticky">
    <div class="container">

        <ul class="buy-button list-inline mb-0">
            <li class="list-inline-item mb-0">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <div class="dropdown dropdown-primary">
                        <button type="button" class="btn btn-icon btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i
                                class="uil uil-user align-middle icons"></i>
                        </button>
                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-3"
                             style="width: 200px;">
                            <a class="dropdown-item text-dark" href="{{route('website.my.profile')}}"><i
                                    class="uil uil-user align-middle me-1"></i>Profile</a>
                            <a class="dropdown-item text-dark" href="#"><i
                                    class="uil uil-clipboard-notes align-middle me-1"></i>My Orders</a>
                            <div class="dropdown-divider my-3 border-top"></div>
                            <a class="dropdown-item text-dark" href="{{route('website.logout')}}"><i
                                    class="uil uil-sign-out-alt align-middle me-1"></i> Logout </a>
                        </div>
                        <x-shopping-cart-button />
                    </div>
                @else
                    <a href="{{route('website.login.index')}}"
                       class="btn btn-icon btn-primary">
                        <i class="uil uil-signin align-middle icons"></i>
                    </a>
                @endif
            </li>
        </ul>

        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li><a href="{{route('website.index')}}" class="sub-menu-item">Home</a></li>
                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">Categories </a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        @foreach(\App\Models\Category::all() as $category)
                            <li><a href="#" class="sub-menu-item">{{$category->name}} </a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="#" class="sub-menu-item">About Us</a></li>
                <li><a href="#" class="sub-menu-item">Contact Us</a></li>

            </ul>
            <!--end login button-->
        </div>
        <!--end navigation-->
    </div>
</header>
