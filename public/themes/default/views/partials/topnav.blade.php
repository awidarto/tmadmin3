<?php
    function sa($item){
        if(URL::to($item) == URL::full() ){
            return  'active';
        }else{
            return '';
        }
    }
?>

<ul class="nav navbar-nav">
    @if(Auth::check())
        <li><a href="{{ URL::to('dashboard') }}" class="submenu {{ sa('dashboard') }}" ><i class="fa fa-dashboard"></i> Dashboard</a></li>

        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-tag"></i> Assets <i class="toggle-accordion"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="submenu {{ sa('asset') }}" href="{{ URL::to('asset') }}"  ><i class="fa fa-th-list"></i> Assets List</a></li>
                <li><a class="submenu {{ sa('rack') }}" href="{{ URL::to('rack') }}"  ><i class="fa fa-th-list"></i> Racks</a></li>
                <li><a class="submenu {{ sa('assetlocation')}}" href="{{ URL::to('assetlocation') }}" ><i class="fa fa-sitemap"></i> Locations</a></li>
                <li><a class="submenu {{ sa('assettype')}}" href="{{ URL::to('assettype') }}" ><i class="fa fa-sitemap"></i> Device Type</a></li>
            </ul>
        </li>

        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-bar-chart-o"></i> Reports
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('report/siteaccess') }}" class="submenu {{ sa('report/siteaccess') }}" ><i class="fa fa-globe"></i> Site Access</a></li>
                <li><a href="{{ URL::to('report/activity') }}" class="submenu {{ sa('report/activity') }}" ><i class="fa fa-refresh"></i> Activity</a></li>
            </ul>
        </li>

        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cogs"></i> System
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('user') }}" class="submenu {{ sa('user') }}" ><i class="fa fa-group"></i> Admins</a></li>
                <li><a href="{{ URL::to('usergroup') }}" class="submenu {{ sa('usergroup') }}" ><i class="fa fa-group"></i> Group</a></li>
                <li><a href="{{ URL::to('option') }}" class="submenu {{ sa('option') }}" ><i class="fa fa-wrench"></i> Options</a></li>
            </ul>
        </li>

    @endif
</ul>
