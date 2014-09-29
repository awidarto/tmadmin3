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
        <li><a href="{{ URL::to('pos') }}" class="submenu {{ sa('pos') }}" ><i class="fa fa-desktop"></i> POS</a></li>

        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-tag"></i> Products <i class="toggle-accordion"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="submenu {{ sa('products') }}" href="{{ URL::to('products') }}"  ><i class="fa fa-th-list"></i> Catalog</a></li>
                <li><a class="submenu {{ sa('productcategory')}}" href="{{ URL::to('productcategory') }}" ><i class="fa fa-sitemap"></i> Category</a></li>
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
                <i class="fa fa-money"></i> Sales<i class="toggle-accordion"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('outlet') }}" class="submenu {{ sa('outlet') }}" ><i class="fa fa-external-link" ></i> Outlets</a></li>
                <li><a href="{{ URL::to('transaction') }}" class="submenu {{ sa('transaction') }}" ><i class="fa fa-credit-card"></i> Transactions List</a></li>
            </ul>
        </li>



        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-bullhorn"></i> Marketing
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('event') }}" class="submenu {{ sa('event') }}" ><i class="fa fa-lightbulb"></i> Events</a></li>
                <li><a href="{{ URL::to('buyer') }}" class="submenu {{ sa('buyer') }}" ><i class="fa fa-group"></i> Buyers</a></li>
                <li><a href="{{ URL::to('contactgroup') }}" class="submenu {{ sa('contactgroup') }}" ><i class="fa fa-folder-close"></i> Contact Groups</a></li>
                <li><a href="{{ URL::to('enquiry') }}" class="submenu {{ sa('enquiry') }}" ><i class="fa fa-question-sign"></i> Enquiries</a></li>
                <li><a href="{{ URL::to('campaign') }}" class="submenu {{ sa('campaign') }}" ><i class="fa fa-bullhorn"></i> Campaign</a></li>

            </ul>
        </li>

        <li class="dropdown show-on-hover">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-file"></i> Templates
                <i class="toggle-accordion"></i>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('newsletter') }}" class="submenu {{ sa('newsletter') }}" ><i class="fa fa-file-alt"></i> Newsletter</a></li>
                <li><a href="{{ URL::to('brochure') }}" class="submenu {{ sa('brochure') }}" ><i class="fa fa-file-alt"></i> Brochure</a></li>
                <li><a href="{{ URL::to('templates') }}" class="submenu {{ sa('templates') }}" ><i class="fa fa-file-alt"></i> Other Templates</a></li>
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
        <li>
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
