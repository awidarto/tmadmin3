<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 footer-sticky navbar-sticky"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 footer-sticky navbar-sticky"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 footer-sticky navbar-sticky"> <![endif]-->
<!--[if gt IE 8]> <html class="ie footer-sticky navbar-sticky"> <![endif]-->
<!--[if !IE]><!--><html class="footer-sticky navbar-sticky"><!-- <![endif]-->
<head>
    <title>{{ Config::get('site.name') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <!--
    **********************************************************
    In development, use the LESS files and the less.js compiler
    instead of the minified CSS loaded by default.
    **********************************************************
    {{--
    <link rel="stylesheet" href="{{ URL::to('coral') }}/assets/css/admin/module.admin.stylesheet-complete.layout_fixed.true.min.css" />
    --}}
    -->
    <link rel="stylesheet/less" href="{{ URL::to('coral') }}/assets/less/admin/module.admin.stylesheet-complete.layout_fixed.true.less" />

    <link rel="stylesheet" href="{{  URL::to('/') }}/css/typography.css">

        <!--[if lt IE 9]><link rel="stylesheet" href="{{ URL::to('coral') }}/assets/components/library/bootstrap/css/bootstrap.min.css" /><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{ URL::to('coral')}}/assets/components/library/jquery/jquery.min.js?v=v1.9.6&sv=v0.0.1"></script>
    <script src="{{ URL::to('coral')}}/assets/components/library/jquery/jquery-migrate.min.js?v=v1.9.6&sv=v0.0.1"></script>
    <script src="{{ URL::to('coral')}}/assets/components/library/modernizr/modernizr.js?v=v1.9.6&sv=v0.0.1"></script>
    <script src="{{ URL::to('coral')}}/assets/components/plugins/less-js/less.min.js?v=v1.9.6&sv=v0.0.1"></script>
    <script src="{{ URL::to('coral')}}/assets/components/modules/admin/charts/flot/assets/lib/excanvas.js?v=v1.9.6&sv=v0.0.1"></script>
    <script src="{{ URL::to('coral')}}/assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.9.6&sv=v0.0.1"></script>
    <script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>

    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>

</head>
<body class=" menu-right-hidden">

    <!-- Main Container Fluid -->
    <div class="container-fluid menu-hidden">

        <!-- Content -->
        <div id="content">


        <div class="navbar hidden-print main navbar-default" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a id="logo" href="{{ URL::to('/')}}" class="animated fadeInDown pull-left"><b class="fa fa-3x fa-headphones"></b></a>
            </div>

            <div class="navbar-collapse collapse">

                @include('partials.topnav')

                <div class="user-action visible-xs user-action-btn-navbar pull-right">
                    <button class="btn btn-sm btn-navbar-right btn-primary btn-stroke"><i class="fa fa-fw fa-arrow-right"></i><span class="menu-left-hidden-xs"> Modules</span></button>
                </div>

                <div class="col-md-3 visible-md visible-lg pull-right padding-none">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" placeholder="Search stories ...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div><!-- /input-group -->
                </div>

                <div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs hidden-xs">
                    <div class="dropdown dropdown-icons padding-none">
                        <a data-toggle="dropdown" href="#" class="btn btn-primary btn-circle dropdown-toggle"><i class="fa fa-user"></i> </a>
                        <ul class="dropdown-menu">
                            <li data-toggle="tooltip" data-title="Photo Gallery" data-placement="left" data-container="body"><a href="gallery_photo.html?lang=en"><i class="fa fa-camera"></i></a></li>
                            <li data-toggle="tooltip" data-title="Tasks" data-placement="left" data-container="body"><a href="tasks.html?lang=en"><i class="fa fa-code-fork"></i></a></li>
                            <li data-toggle="tooltip" data-title="Employees" data-placement="left" data-container="body"><a href="employees.html?lang=en"><i class="fa fa-group"></i></a></li>
                            <li data-toggle="tooltip" data-title="Contacts" data-placement="left" data-container="body"><a href="contacts_2.html?lang=en"><i class="fa fa-phone-square"></i></a></li>
                        </ul>
                    </div>
                </div>

                <ul class="notifications pull-right hidden-xs">
                    <li class="dropdown notif">
                        <a href="" class="dropdown-toggle"  data-toggle="dropdown"><i class="notif-block fa fa-comments-o"></i><span class="badge badge-primary">7</span></a>
                        <ul class="dropdown-menu chat media-list">
                            <li class="media">
                                <a class="pull-left" href="#"><img class="media-object thumb" src="{{ URL::to('coral')}}/assets/images/people/100/15.jpg" alt="50x50" width="50"/></a>
                                <div class="media-body">
                                    <span class="label label-default pull-right">5 min</span>
                                    <h5 class="media-heading">Adrian D.</h5>
                                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                </div>
                            </li>
                            <li class="media">
                                <a class="pull-left" href="#"><img class="media-object thumb" src="{{ URL::to('coral')}}/assets/images/people/100/16.jpg" alt="50x50" width="50"/></a>
                                <div class="media-body">
                                    <span class="label label-default pull-right">2 days</span>
                                    <h5 class="media-heading">Jane B.</h5>
                                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                </div>
                            </li>
                            <li class="media">
                                <a class="pull-left" href="#"><img class="media-object thumb" src="{{ URL::to('coral')}}/assets/images/people/100/17.jpg" alt="50x50" width="50"/></a>
                                <div class="media-body">
                                    <span class="label label-default pull-right">3 days</span>
                                    <h5 class="media-heading">Andrew M.</h5>
                                    <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                </div>
                            </li>
                            <li><a href="#" class="btn btn-primary"><i class="fa fa-list"></i> <span>View all messages</span></a></li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
</div>
<!-- // END navbar -->



{{--
<div id="menu-top" class="menu-top-inverse">
    <div class="container"> <ul class="main pull-left">
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-cog"></i> Layout <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="active"><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true" class="no-ajaxify">Fixed Layout with Top menu</a></li>
                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=false" class="no-ajaxify">Fluid Layout with Sidebars</a></li>
                <li><a href="layout/layout-fixed-menu-top.html?lang=en" class="no-ajaxify">Layout examples</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-suitcase"></i> UI KIT <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="ui.html?lang=en">UI Elements</a></li>
                <li><a href="icons.html?lang=en">Icons</a></li>
                <li><a href="typography.html?lang=en">Typography</a></li>
                <li><a href="widgets.html?lang=en">Widgets</a></li>
                <li><a href="calendar.html?lang=en">Calendar</a></li>
                <li><a href="tabs.html?lang=en">Tabs</a></li>
                <li><a href="sliders.html?lang=en">Sliders</a></li>
                <li><a href="charts.html?lang=en">Charts</a></li>
                <li><a href="grid.html?lang=en">Grid</a></li>
                <li><a href="notifications.html?lang=en">Notifications</a></li>
                <li><a href="modals.html?lang=en">Modals</a></li>
                <li><a href="thumbnails.html?lang=en">Thumbnails</a></li>
                <li><a href="carousels.html?lang=en">Carousels</a></li>
                <li><a href="image_crop.html?lang=en">Image Cropping</a></li>
                <li><a href="twitter.html?lang=en">Twitter API</a></li>
                <li><a href="infinite_scroll.html?lang=en">Infinite Scroll</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-check-square-o"></i> Forms <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="form_wizards.html?lang=en">Form Wizards</a></li>
                <li><a href="form_elements.html?lang=en">Form Elements</a></li>
                <li><a href="form_validator.html?lang=en">Form Validator</a></li>
                <li><a href="file_managers.html?lang=en">File Managers</a></li>
            </ul>
        </li>
        <li class="dropdown hidden-xs">
            <a data-toggle="dropdown" class="dropdown-toggle" href=""><i class="fa fa-fw fa-table"></i> Tables <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="tables.html?lang=en">Tables</a></li>
                <li><a href="tables_responsive.html?lang=en">Responsive Tables</a></li>
                <li><a href="pricing_tables.html?lang=en">Pricing Tables</a></li>
            </ul>
        </li>
    </ul>
    <ul class="main pull-right visible-lg">
        <li><a href="">Close <i class="fa fa-fw fa-times"></i></a></li>
    </ul>
    <ul class="colors pull-right hidden-xs">

                <li class="active"><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=style-default" style="background-color: #eb6a5a" class="no-ajaxify"><span class="hide">style-default</span></a></li>
                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=green" style="background-color: #87c844" class="no-ajaxify"><span class="hide">green</span></a></li>
                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=coral" style="background-color: #7eccc2" class="no-ajaxify"><span class="hide">coral</span></a></li>

        <li class="dropdown">
            <a href="" data-toggle="dropdown" class="dropdown-toggle">
                <span class="color inverse"></span>
                <span class="color danger"></span>
                <span class="color success"></span>
                <span class="color info"></span>
            </a>
            <ul class="dropdown-menu pull-right">
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=alizarin-crimson" class="no-ajaxify"><span class="color" style="background-color: #F06F6F"></span> alizarin-crimson</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=blue-gray" class="no-ajaxify"><span class="color" style="background-color: #7293CF"></span> blue-gray</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=brown" class="no-ajaxify"><span class="color" style="background-color: #d39174"></span> brown</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=purple-gray" class="no-ajaxify"><span class="color" style="background-color: #AF86B9"></span> purple-gray</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=purple-wine" class="no-ajaxify"><span class="color" style="background-color: #CC6788"></span> purple-wine</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=green-army" class="no-ajaxify"><span class="color" style="background-color: #9FB478"></span> green-army</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=black-and-white" class="no-ajaxify"><span class="color" style="background-color: #979797"></span> black-and-white</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=amazon" class="no-ajaxify"><span class="color" style="background-color: #8BC4B9"></span> amazon</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=amber" class="no-ajaxify"><span class="color" style="background-color: #CACA8A"></span> amber</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=android-green" class="no-ajaxify"><span class="color" style="background-color: #A9C784"></span> android-green</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=antique-brass" class="no-ajaxify"><span class="color" style="background-color: #B3998A"></span> antique-brass</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=antique-bronze" class="no-ajaxify"><span class="color" style="background-color: #8D8D6E"></span> antique-bronze</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=artichoke" class="no-ajaxify"><span class="color" style="background-color: #B0B69D"></span> artichoke</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=atomic-tangerine" class="no-ajaxify"><span class="color" style="background-color: #F19B69"></span> atomic-tangerine</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=bazaar" class="no-ajaxify"><span class="color" style="background-color: #98777B"></span> bazaar</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=bistre-brown" class="no-ajaxify"><span class="color" style="background-color: #C3A961"></span> bistre-brown</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=bittersweet" class="no-ajaxify"><span class="color" style="background-color: #d6725e"></span> bittersweet</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=blueberry" class="no-ajaxify"><span class="color" style="background-color: #7789D1"></span> blueberry</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=bud-green" class="no-ajaxify"><span class="color" style="background-color: #6fa362"></span> bud-green</a></li>
                                <li><a href="?module=admin&page=index&url_rewrite=&build=&v=v1.9.6&layout_fixed=true&skin=burnt-sienna" class="no-ajaxify"><span class="color" style="background-color: #E4968A"></span> burnt-sienna</a></li>
                            </ul>
        </li>
    </ul>
    </div>
</div>
--}}


            <div class="layout-app">

            <div class="container-fluid">
                        <!-- row -->
                        <div class="row margin-none">

                            @yield('content')

                        </div>
                        <!-- // END row -->

                    </div>
                    <!-- // END col-app -->

                </div>
                <!-- // END col-table-row -->

            </div>
            <!-- // END col-table -->

        </div>
        <!-- // END col-separator -->

    </div>
    <!-- // END col -->

</div>
<!-- // END row-app -->




        </div>
        </div>
        </div>
        <!-- // Content END -->

        <div class="clearfix"></div>
        <!-- // Sidebar menu & content wrapper END -->

                <!-- Footer -->
        <div id="footer" class="hidden-print">
            <div class="copy">&copy; 2012 - 2014 - {{ Config::get('site.name') }} - All Rights Reserved.</div>
            <!--  End Copyright Line -->
        </div>
        <!-- // Footer END -->


    </div>
    <!-- // Main Container Fluid END -->

    <!-- Global -->
    <script data-id="App.Config">
    var basePath = '',
        commonPath = '../assets/',
        rootPath = '../',
        DEV = false,
        componentsPath = '../assets/components/',
        layoutApp = false,
        module = 'admin';

    var primaryColor = '#eb6a5a',
        dangerColor = '#b55151',
        successColor = '#609450',
        infoColor = '#4a8bc2',
        warningColor = '#ab7a4b',
        inverseColor = '#45484d';

    var themerPrimaryColor = primaryColor;
    </script>

    <script src="{{ URL::to('coral')}}/assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/plugins/breakpoints/breakpoints.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/plugins/preload/pace/pace.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/core/js/preload.pace.init.js?v=v1.9.6"></script>
<script src="{{ URL::to('coral')}}/assets/components/common/gallery/blueimp-gallery/assets/lib/js/blueimp-gallery.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/common/gallery/blueimp-gallery/assets/lib/js/jquery.blueimp-gallery.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral')}}/assets/components/plugins/image-preview/image-preview.js?v=v1.9.6&sv=v0.0.1"></script>

<!-- graphs -->
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/lib/jquery.flot.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/lib/jquery.flot.resize.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/lib/plugins/jquery.flot.tooltip.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/custom/js/flotcharts.common.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/custom/js/flotchart-line-2.init.js?v=v1.9.6"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/custom/js/flotchart-bars-horizontal.init.js?v=v1.9.6"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/flot/assets/custom/js/flotchart-mixed-1.init.js?v=v1.9.6"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/easy-pie/assets/lib/js/jquery.easy-pie-chart.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/easy-pie/assets/custom/easy-pie.init.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/sparkline/jquery.sparkline.min.js?v=v1.9.6&sv=v0.0.1"></script>
<script src="{{ URL::to('coral') }}/assets/components/modules/admin/charts/sparkline/sparkline.init.js?v=v1.9.6&sv=v0.0.1"></script>


<script src="{{ URL::to('coral')}}/assets/components/core/js/core.init.js?v=v1.9.6"></script>
<script src="{{ URL::to('coral')}}/assets/components/core/js/animations.init.js?v=v1.9.6"></script>

    @include('layout.js')


</body>
</html>