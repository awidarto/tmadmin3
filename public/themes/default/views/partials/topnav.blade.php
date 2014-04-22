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

        <li><a href="{{ URL::to('stockcheck') }}" {{ sa('stockcheck') }} >Stock Check</a></li>

        <li><a href="{{ URL::to('products') }}" {{ sa('products') }} >Products</a></li>
        <li><a href="{{ URL::to('inventory') }}" {{ sa('inventory') }} >Inventory</a></li>
        <li><a href="{{ URL::to('outlet') }}" {{ sa('outlet') }} >Outlets</a></li>

        <li><a href="{{ URL::to('transaction') }}" {{ sa('transaction') }} >Transactions</a></li>

        <li><a href="{{ URL::to('buyer') }}" {{ sa('buyer') }} >Buyers</a></li>
        <li><a href="{{ URL::to('user') }}" {{ sa('user') }} >Admins</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Reports
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('report/siteaccess') }}" {{ sa('report/siteaccess') }} >Site Access</a></li>
                <li><a href="{{ URL::to('report/activity') }}" {{ sa('report/activity') }} >Activity</a></li>
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
                <li><a href="{{ URL::to('content/category') }}" {{ sa('content/category') }} >Category</a></li>
                <li><a href="{{ URL::to('content/menu') }}" {{ sa('content/menu') }} >Menu</a></li>
            </ul>
        </li>
    @endif
</ul>
