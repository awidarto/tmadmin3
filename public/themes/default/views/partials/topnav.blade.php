<?php
    function sa($item){
        if(URL::to($item) == URL::full() ){
            return  'class="active"';
        }else{
            return '';
        }
    }
?>
<ul class="nav">
    @if(Auth::check())
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Products
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('products') }}" {{ sa('products') }} >Products</a></li>
                <li><a href="{{ URL::to('productcategory') }}" {{ sa('productcategory') }} >Product Category</a></li>
                <li><a href="{{ URL::to('outlet') }}" {{ sa('outlet') }} >Outlets</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Transactions
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('transaction') }}" {{ sa('transaction') }} >Orders</a></li>
                <li><a href="{{ URL::to('buyer') }}" {{ sa('buyer') }} >Buyers</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Promotions
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('event') }}" {{ sa('event') }} >Events</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Operational
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('user') }}" {{ sa('user') }} >Admins</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Reports
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('activity') }}" {{ sa('activity') }} >Activity Log</a></li>
                <li><a href="{{ URL::to('siteaccess') }}" {{ sa('siteaccess') }} >Site Access</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Site Content
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('content/pages') }}" {{ sa('content/pages') }} >Pages</a></li>
                <li><a href="{{ URL::to('content/posts') }}" {{ sa('content/posts') }} >Posts</a></li>
                <li><a href="{{ URL::to('content/section') }}" {{ sa('content/section') }} >Section</a></li>
                <li><a href="{{ URL::to('content/category') }}" {{ sa('content/category') }} >Category</a></li>
                <li><a href="{{ URL::to('content/menu') }}" {{ sa('content/menu') }} >Menu</a></li>
                <li><a href="{{ URL::to('video') }}" {{ sa('video') }} >Promo Videos</a></li>
                <li><a href="{{ URL::to('faq') }}" {{ sa('faq') }} >FAQ Entries</a></li>
                <li><a href="{{ URL::to('faqcat') }}" {{ sa('faqcat') }} >Category</a></li>
            </ul>
        </li>
    @endif
</ul>
