            <ul class="nav navbar-nav navbar-right hidden-xs">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar }}" class="avatar pull-left img-circle" alt="user" title="user">
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ URL::to('profile')}}">
                                {{ Auth::user()->fullname }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('logout')}}" ><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>


