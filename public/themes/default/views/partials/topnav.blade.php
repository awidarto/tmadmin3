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

        <li><a href="{{ URL::to('pos') }}" {{ sa('pos') }} >POS</a></li>
        <li><a href="{{ URL::to('dashboard') }}" {{ sa('dashboard') }} >Stock Check</a></li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Products
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('products') }}" {{ sa('products') }} >Catalog</a></li>
                <li><a href="{{ URL::to('productcategory') }}" {{ sa('productcategory') }} >Category</a></li>
            </ul>
        </li>

        <li><a href="{{ URL::to('inventory') }}" {{ sa('inventory') }} >Inventory</a></li>
        <li><a href="{{ URL::to('outlet') }}" {{ sa('outlet') }} >Outlets</a></li>

        <li><a href="{{ URL::to('transaction') }}" {{ sa('transaction') }} >Transactions</a></li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Marketing
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('buyer') }}" {{ sa('buyer') }} >Contact List</a></li>
                <li><a href="{{ URL::to('contactgroup') }}" {{ sa('contactgroup') }} >Contact Groups</a></li>
                <li><a href="{{ URL::to('enquiry') }}" {{ sa('enquiry') }} >Enquiries</a></li>
                <li><a href="{{ URL::to('campaign') }}" {{ sa('campaign') }} >Campaign</a></li>
                <li><a href="{{ URL::to('newsletter') }}" {{ sa('newsletter') }} >Newsletter</a></li>
                <li><a href="{{ URL::to('brochure') }}" {{ sa('brochure') }} >Brochure</a></li>
            </ul>
        </li>


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
                <li><a href="{{ URL::to('content/section') }}" {{ sa('content/section') }} >Section</a></li>
                <li><a href="{{ URL::to('content/category') }}" {{ sa('content/category') }} >Category</a></li>
                <li><a href="{{ URL::to('content/menu') }}" {{ sa('content/menu') }} >Menu</a></li>
                <li><a href="{{ URL::to('homeslide') }}" {{ sa('homeslide') }} >Home Slide Show</a></li>
                <li><a href="{{ URL::to('faq') }}" {{ sa('faq') }} >FAQ Entries</a></li>
                <li><a href="{{ URL::to('faqcat') }}" {{ sa('faqcat') }} >FAQ Category</a></li>
                <li><a href="{{ URL::to('glossary') }}" {{ sa('glossary') }} >Glossary Entries</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                System
                <b class="caret"></b>
              </a>
            <ul class="dropdown-menu">
                <li><a href="{{ URL::to('user') }}" {{ sa('user') }} >Admins</a></li>
                <li><a href="{{ URL::to('option') }}" {{ sa('option') }} >Options</a></li>
            </ul>
        </li>

    @endif
</ul>
