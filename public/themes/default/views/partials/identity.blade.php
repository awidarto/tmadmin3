            <ul class="nav navbar-nav navbar-right hidden-xs">
                <li class="hidden-xs">
                    <a href="profile.html">
                        {{ Auth::user()->fullname }}
                    </a>
                </li>
                {{--
                <li class="notifications dropdown hidden-xs">
                    <a href="#" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <div class="badge badge-top bg-danger animated flash">3</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated slideInRight">
                        <div class="panel bg-white no-border no-margin">
                            <div class="panel-heading no-radius">
                                <small>
                                    <b>Notifications</b>
                                </small>
                                <small class="pull-right">
                                    <a href="#" class="mg-r-xs">mark as read</a>&#8226;
                                    <a href="#" class="fa fa-cog mg-l-xs"></a>
                                </small>
                            </div>

                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="#">
                                        <span class="pull-left mg-t-xs mg-r-md">
                                            <img src="{{ URL::to('cameo')}}/img/face4.jpg" class="avatar avatar-sm img-circle" alt="">
                                        </span>
                                        <div class="m-body show pd-t-xs">
                                            <span>Dean Winchester</span>
                                            <span>Posted on to your wall</span>
                                            <small>2 mins ago</small>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#">
                                        <span class="pull-left mg-t-xs mg-r-md">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                <i class="fa fa-download fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div class="m-body show pd-t-xs">
                                            <span>145 MB download in progress.</span>
                                            <div class="progress progress-xs mg-t-xs mg-b-xs">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                </div>
                                            </div>
                                            <small>Started 23 mins ago</small>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#">
                                        <span class="pull-left mg-t-xs mg-r-md">
                                            <img src="{{ URL::to('cameo')}}/img/face3.jpg" class="avatar avatar-sm img-circle" alt="">
                                        </span>
                                        <div class="m-body show pd-t-xs">
                                            <span>Application</span>
                                            <span>Where is my workspace widget</span>
                                            <small>5 days ago</small>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                            <div class="panel-footer no-border">
                                <a href="#">See all notifications</a>
                            </div>
                        </div>
                    </div>
                </li>

                --}}
                <li class="quickmenu mg-r-md">
                    <a href="#" data-toggle="dropdown">
                        <img src="{{ URL::to('cameo')}}/img/avatar.jpg" class="avatar pull-left img-circle" alt="user" title="user">
                        <i class="caret mg-l-xs hidden-xs no-margin"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right mg-r-xs">
                        <li>
                            <a href="#">
                                <div class="pd-t-sm">
                                    {{ Auth::user()->email }}
                                </div>
                            </a>
                        </li>
                        {{--

                        <li>
                            <a href="profile.html">Settings</a>
                        </li>
                        <li>
                            <a href="#">Upgrade</a>
                        </li>
                        <li>
                            <a href="#">Notifications
                                <div class="badge bg-danger pull-right">3</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">Help ?</a>
                        </li>
                        --}}
                        <li class="divider"></li>
                        <li>
                            <a href="{{ URL::to('logout')}}">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>


