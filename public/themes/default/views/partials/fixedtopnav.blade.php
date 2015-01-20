    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand {{ sa('dashboard') }} " href="{{ URL::to('/') }}">{{ Config::get('site.name')}}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown  class="{{ sa('asset') }}"">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false"><i class="fa fa-cubes"></i> Assets <span class="caret"></span></a>
                <ul class="dropdown-menu pull-left">
                    <li class="{{ sa('asset') }}">
                        <a class="{{ sa('asset') }}" href="{{ URL::to('asset') }}"  ><i class="fa fa-th-list"></i> Assets List</a>
                    </li>
                    <li class="{{ sa('rack') }}">
                        <a class="{{ sa('rack') }}" href="{{ URL::to('rack') }}"  ><i class="fa fa-th-list"></i> Racks</a>
                    </li>
                    <li class="{{ sa('assetlocation')}}">
                        <a class="{{ sa('assetlocation')}}" href="{{ URL::to('assetlocation') }}" ><i class="fa fa-map-marker"></i> Locations</a>
                    </li>
                    <li class="{{ sa('assettype')}}">
                        <a class="{{ sa('assettype')}}" href="{{ URL::to('assettype') }}" ><i class="fa fa-sitemap"></i> Device Type</a>
                    </li>

                </ul>
            </li>
            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-check-square-o"></i> Approval <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('approval') }}" >
                        <a href="{{ URL::to('approval') }}" class="{{ sa('approval') }}" ><i class="fa fa-clock-o"></i> Pending</a>
                    </li>
                    <li class="{{ sa('activity') }}" >
                        <a href="{{ URL::to('activity') }}" class="{{ sa('activity') }}" ><i class="fa fa-check-circle-o"></i> Verified</a>
                    </li>
                    {{--
                    <li class="{{ sa('access') }}">
                        <a href="{{ URL::to('access') }}" class="{{ sa('access') }}" ><i class="fa fa-edit"></i> To Be Revised</a>
                    </li>
                    <li class="{{ sa('apiaccess') }}">
                        <a href="{{ URL::to('apiaccess') }}" class="{{ sa('apiaccess') }}" ><i class="fa fa-times-circle-o"></i> Rejected</a>
                    </li>
                    --}}
                </ul>
            </li>
            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-list"></i> Logs <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('activity') }}" >
                        <a href="{{ URL::to('activity') }}" class="{{ sa('activity') }}" ><i class="fa fa-refresh"></i> Audit Trails</a>
                    </li>
                    <li class="{{ sa('activity') }}" >
                        <a href="{{ URL::to('activity') }}" class="{{ sa('activity') }}" ><i class="fa fa-refresh"></i> Site Activity</a>
                    </li>
                    <li class="{{ sa('access') }}">
                        <a href="{{ URL::to('access') }}" class="{{ sa('access') }}" ><i class="fa fa-globe"></i> Site Access</a>
                    </li>
                    <li class="{{ sa('apiaccess') }}">
                        <a href="{{ URL::to('apiaccess') }}" class="{{ sa('apiaccess') }}" ><i class="fa fa-plug"></i> API Access</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-bar-chart-o"></i> Reports <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('activity') }}" >
                        <a href="{{ URL::to('activity') }}" class="{{ sa('activity') }}" ><i class="fa fa-refresh"></i> Audit Trails</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-cogs"></i> System <span class="caret"></span>
                  </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('user') }}" >
                      <a href="{{ URL::to('user') }}" class="{{ sa('user') }}" ><i class="fa fa-group"></i> Admins</a>
                    </li>
                    <li class="{{ sa('usergroup') }}">
                      <a href="{{ URL::to('usergroup') }}" class="{{ sa('usergroup') }}" ><i class="fa fa-group"></i> Group</a>
                    </li>
                    <li class="{{ sa('option') }}">
                      <a href="{{ URL::to('option') }}" class="{{ sa('option') }}" ><i class="fa fa-wrench"></i> Options</a>
                    </li>
                </ul>
            </li>
          </ul>

          @include('partials.identity')

        </div><!--/.nav-collapse -->
      </div>
    </nav>
