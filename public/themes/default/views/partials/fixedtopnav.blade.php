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
            <a class="navbar-brand {{ sa('dashboard') }} " href="{{ URL::to('/') }}">
                <img style="width:75px;" src="{{ URL::to('/')}}/images/tm_logo_trans_sm.png" alt="{{ Config::get('site.name') }}" />
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            <li class="{{ sa('dashboard') }}" ><a href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="{{ sa('pos') }}" ><a href="{{ URL::to('pos') }}"><i class="fa fa-desktop"></i> POS</a></li>

            <li class="dropdown {{ sa('products') }} {{ sa('productcategory')}}">
                <a href="#" data-toggle="dropdown">
                    <i class="fa fa-tag"></i> Products <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('products') }}"><a class="{{ sa('products') }}" href="{{ URL::to('products') }}"  ><i class="fa fa-th-list"></i> Catalog</a></li>
                    <li class="{{ sa('productcategory')}}"><a href="{{ URL::to('productcategory') }}" ><i class="fa fa-sitemap"></i> Category</a></li>
                </ul>
            </li>
            <li class="dropdown {{ sa('inventory') }} {{ sa('stockcheck') }} {{ sa('stockchecklist') }}">
                <a href="#" data-toggle="dropdown">
                    <i class="fa fa-check"></i> Stock <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('inventory') }}" ><a href="{{ URL::to('inventory') }}"><i class="fa fa-tags"></i> Stock List</a></li>
                    <li class="{{ sa('stockcheck') }}" ><a  href="{{ URL::to('stockcheck') }}"><i class="fa fa-barcode"></i> Stock Check</a></li>
                    <li class="{{ sa('stockchecklist') }}" ><a href="{{ URL::to('stockchecklist') }}"><i class="fa fa-table"></i> Stock Check Log</a></li>
                </ul>
            </li>

            <li class="dropdown {{ sa('salesreport') }} {{ sa('outlet') }} {{ sa('transaction') }}">
                <a href="#" data-toggle="dropdown">
                    <i class="fa fa-money"></i> Sales <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('salesreport') }}" ><a href="{{ URL::to('salesreport') }}"><i class="fa fa-external-link" ></i> Sales Report</a></li>
                    <li class="{{ sa('outlet') }}" ><a href="{{ URL::to('outlet') }}"><i class="fa fa-external-link" ></i> Outlets</a></li>
                    <li class="{{ sa('transaction') }}" ><a href="{{ URL::to('transaction') }}"><i class="fa fa-credit-card"></i> Transactions List</a></li>
                </ul>
            </li>



            <li class="dropdown {{ sa('event') }} {{ sa('buyer') }} {{ sa('contactgroup') }} {{ sa('enquiry') }} {{ sa('campaign') }}">
                <a href="#" data-toggle="dropdown">
                    <i class="fa fa-bullhorn"></i> Marketing <span class="caret"></span>
                  </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('event') }}><a href="{{ URL::to('event') }}" ><i class="fa fa-lightbulb"></i> Events</a></li>
                    <li class="{{ sa('buyer') }}" ><a href="{{ URL::to('buyer') }}"><i class="fa fa-group"></i> Buyers</a></li>
                    <li class="{{ sa('contactgroup') }}" ><a href="{{ URL::to('contactgroup') }}"><i class="fa fa-folder-close"></i> Contact Groups</a></li>
                    <li class="{{ sa('enquiry') }}" ><a href="{{ URL::to('enquiry') }}"><i class="fa fa-question-sign"></i> Enquiries</a></li>
                    <li class="{{ sa('campaign') }}" ><a href="{{ URL::to('campaign') }}"><i class="fa fa-bullhorn"></i> Campaign</a></li>

                </ul>
            </li>

            <li class="dropdown {{ sa('newsletter') }} {{ sa('brochure') }} {{ sa('templates') }}">
                <a href="" data-toggle="dropdown">
                    <i class="fa fa-file"></i> Templates <span class="caret"></span>
                  </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('newsletter') }}" ><a href="{{ URL::to('newsletter') }}"><i class="fa fa-file-alt"></i> Newsletter</a></li>
                    <li class="{{ sa('brochure') }}" ><a href="{{ URL::to('brochure') }}"><i class="fa fa-file-alt"></i> Brochure</a></li>
                    <li class="{{ sa('templates') }}" ><a href="{{ URL::to('templates') }}"><i class="fa fa-file-alt"></i> Other Templates</a></li>
                </ul>
            </li>

            {{-- Log tab --}}
            @if(Ks::can('view','log'))

            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-list"></i> Logs <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
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

            @endif

            {{-- System tab --}}
            <li class="dropdown {{ sa('user') }} {{ sa('usergroup') }} {{ sa('option') }}">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-cogs"></i> System <span class="caret"></span>
                  </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('user') }}" >
                      <a href="{{ URL::to('user') }}" class="{{ sa('user') }}" ><i class="fa fa-group"></i> Users</a>
                    </li>
                    <li class="{{ sa('usergroup') }}">
                      <a href="{{ URL::to('usergroup') }}" class="{{ sa('usergroup') }}" ><i class="fa fa-group"></i> Roles</a>
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
