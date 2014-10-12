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
                <li><a class="submenu {{ sa('assettype')}}" href="{{ URL::to('assettype') }}" ><i class="fa fa-sitemap"></i> Asset Type</a></li>
            </ul>
        </li>
        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-check"></i> Stock<i class="toggle-accordion"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('inventory') }}" class="submenu {{ sa('inventory') }}" ><i class="fa fa-tags"></i> Stock List</a></li>
                <li><a href="{{ URL::to('stockcheck') }}" class="submenu {{ sa('stockcheck') }}" ><i class="fa fa-barcode"></i> Stock Check</a></li>
                <li><a href="{{ URL::to('stockchecklist') }}" class="submenu {{ sa('stockchecklist') }}" ><i class="fa fa-table"></i> Stock Check Log</a></li>
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
                <i class="fa fa-sitemap"></i> Site Content
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('content/pages') }}" class="submenu {{ sa('content/pages') }}" ><i class="fa fa-copy"></i> Pages</a></li>
                <li><a href="{{ URL::to('content/posts') }}" class="submenu {{ sa('content/posts') }}" ><i class="fa fa-copy"></i> Posts</a></li>
                <li><a href="{{ URL::to('content/section') }}" class="submenu {{ sa('content/section') }}" ><i class="fa fa-sitemap"></i> Section</a></li>
                <li><a href="{{ URL::to('content/category') }}" class="submenu {{ sa('content/category') }}" ><i class="fa fa-sitemap"></i> Category</a></li>
                <li><a href="{{ URL::to('content/menu') }}" class="submenu {{ sa('content/menu') }}" ><i class="fa fa-sitemap"></i> Menu</a></li>
                <li><a href="{{ URL::to('showcase') }}" class="submenu {{ sa('showcase') }}" ><i class="fa fa-eye-open"></i> Showcases</a></li>
                <li><a href="{{ URL::to('homeslide') }}" class="submenu {{ sa('homeslide') }}" ><i class="fa fa-home"></i> Home Slide Show</a></li>
                <li><a href="{{ URL::to('header') }}" class="submenu {{ sa('header') }}" ><i class="fa fa-home"></i> Site Header</a></li>
                <li><a href="{{ URL::to('faq') }}" class="submenu {{ sa('faq') }}" ><i class="fa fa-question-sign"></i> FAQ Entries</a></li>
                <li><a href="{{ URL::to('faqcat') }}" class="submenu {{ sa('faqcat') }}" ><i class="fa fa-sitemap"></i> FAQ Category</a></li>
                <li><a href="{{ URL::to('glossary') }}" class="submenu {{ sa('glossary') }}" ><i class="fa fa-list"></i> Glossary Entries</a></li>
            </ul>
        </li>
        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cogs"></i> System
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('user') }}" class="submenu {{ sa('user') }}" ><i class="fa fa-group"></i> Admins</a></li>
                <li><a href="{{ URL::to('option') }}" class="submenu {{ sa('option') }}" ><i class="fa fa-wrench"></i> Options</a></li>
            </ul>
        </li>

    @endif
</ul>
