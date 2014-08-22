<!DOCTYPE html>
<html lang="en">
<head>

    <!-- start: Meta -->
    <meta charset="utf-8" />
    <title>{{ Config::get('site.name')}}</title>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keyword" content="" />
    <!-- end: Meta -->

    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- end: Mobile Specific -->

    <!-- start: CSS -->

    <link href="{{ URL::to('sm')}}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ URL::to('sm')}}/css/bootstrap-responsive.min.css" rel="stylesheet" />

    {{ HTML::style('css/typography.css') }}
    <link href="{{ URL::to('sm')}}/css/style.min.css" rel="stylesheet" />
    <link href="{{ URL::to('sm')}}/css/style-responsive.min.css" rel="stylesheet" />
    <link href="{{ URL::to('sm')}}/css/retina.css" rel="stylesheet" />

    {{ HTML::style('css/app2.css') }}

    {{ HTML::style('css/form.css') }}

    {{ HTML::style('css/gridtable.css') }}
    {{ HTML::style('css/jquery.tagsinput.css') }}

    {{ HTML::style('css/bootstrap-modal.css') }}

    {{ HTML::style('datatables/css/dataTables.bootstrap.css')}}
    {{-- HTML::style('datatables/css/dataTables.responsive.css')--}}

    {{ HTML::style('css/sm-datepicker/bootstrap-datetimepicker.min.css') }}

    {{ HTML::style('css/flick/jquery-ui-1.9.2.custom.min.css') }}

    {{ HTML::style('css/pickacolor/pick-a-color-1.1.8.min.css') }}

    {{ HTML::style('css/daterangepicker-bs2.css') }}

    {{ HTML::style('css/blueimp-gallery.min.css') }}

    {{ HTML::style('css/bootstrap-select.css')}}

    <!-- end: CSS -->


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <link id="ie-style" href="{{ URL::to('sm')}}/css/ie.css" rel="stylesheet">
    <![endif]-->

    <!--[if IE 9]>
        <link id="ie9style" href="{{ URL::to('sm')}}/css/ie9.css" rel="stylesheet">
    <![endif]-->

    <!-- start: Favicon and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
    <link rel="shortcut icon" href="{{ URL::to('sm')}}/ico/favicon.png" />
    <!-- end: Favicon and Touch Icons -->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    {{ HTML::script('js/jquery-1.11.1.min.js')}}
    <script src="{{ URL::to('sm')}}/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="{{ URL::to('sm')}}/js/jquery-ui-1.10.3.custom.min.js"></script>


    <script type="text/javascript">
        var base = '{{ URL::to('/') }}/';
    </script>

    <style type="text/css">
        a.brand{
            padding-top: 2px !important;
            background-color: #0098a6 !important;
            padding-bottom: 3px !important;
        }

        .navbar-inner{
            background-color: #74A6BD;
        }
    </style>

<body>
        <!-- start: Header -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>
                <div class="row-fluid">
                <a class="brand span2" href="index.html" style="padding:0px;"><img style="width:105px;" src="{{ URL::to('images/tmlogo_med.png')}}" alt="{{ Config::get('site.name') }}"></a>
                </div>
                <!-- start: Header Menu -->
                <div class="nav-no-collapse header-nav">
                    @include('partials.identity')
                </div>
                <!-- end: Header Menu -->

            </div>
        </div>
    </div>
    <!-- start: Header -->

        <div class="container-fluid-full">
        <div class="row-fluid">

            <!-- start: Main Menu -->
            <div id="sidebar-left" class="span2" style="overflow-y:auto;">

                <div class="row-fluid actions">

                    <input type="text" class="search span12" placeholder="..." />

                </div>

                <div class="nav-collapse sidebar-nav" style="display:block;">
                    @include('partials.topnav')
                    {{--
                    <ul class="nav nav-tabs nav-stacked main-menu">
                        <li><a href="index.html"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>
                        <li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
                        <li><a href="widgets.html"><i class="icon-dashboard"></i><span class="hidden-tablet"> Widgets</span></a></li>
                        <li>
                            <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Example Pages</span> <span class="label">3</span></a>
                            <ul>
                                <li><a class="submenu" href="infrastructure.html"><i class="icon-hdd"></i><span class="hidden-tablet"> Infrastructure</span></a></li>
                                <li><a class="submenu" href="messages.html"><i class="icon-envelope"></i><span class="hidden-tablet"> Messages</span></a></li>
                                <li><a class="submenu" href="tasks.html"><i class="icon-tasks"></i><span class="hidden-tablet"> Tasks</span></a></li>
                            </ul>
                        </li>
                        <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
                        <li><a href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
                        <li><a href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
                        <li><a href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
                        <li><a href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
                        <li><a href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
                        <li><a href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
                        <li><a href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
                        <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>
                    </ul>

                    --}}
                </div>
            </div>
            <!-- end: Main Menu -->

            <!-- start: Content -->
            <div id="content" class="span10">


                @yield('content')


            </div>
            <!-- end: Content -->

                </div><!--/fluid-row-->

        <div class="modal hide fade" id="myModal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Settings</h3>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Close</a>
                <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <footer>
            <p>
                <span style="text-align:left;float:left">&copy; 2013 <a href="http://toimoi.co.id" alt="Toimoi Art+Design">Toimoi art+design</a></span>
            </p>

        </footer>

    </div><!--/.fluid-container-->

    <!-- start: JavaScript-->
        <script src="{{ URL::to('sm')}}/js/jquery.ui.touch-punch.js"></script>
        <script src="{{ URL::to('sm')}}/js/modernizr.js"></script>
        <script src="{{ URL::to('sm')}}/js/bootstrap.min.js"></script>

    {{ HTML::script('js/bootstrap-modalmanager.js') }}
    {{ HTML::script('js/bootstrap-modal.js') }}

    {{ HTML::script('js/jquery.removeWhitespace.min.js')}}
    {{ HTML::script('js/jquery.collagePlus.min.js')}}
    {{ HTML::script('js/jquery.collageCaption.js')}}
    {{ HTML::script('datatables/js/jquery.datatables.min.js')}}
    {{ HTML::script('datatables/js/dataTables.bootstrap.js')}}
    {{-- HTML::script('datatables/js/dataTables.responsive.js') --}}
    {{ HTML::script('js/jquery.dataTables.rowReordering.js') }}
    {{ HTML::script('js/jquery.dataTables.rowGrouping.js') }}

    {{ HTML::script('js/jquery.tagsinput.js') }}

    {{-- HTML::script('js/bootstrap-timepicker.js') --}}
    {{ HTML::script('js/sm-datepicker/bootstrap-datetimepicker.min.js') }}

    {{ HTML::script('js/moment.min.js') }}
    {{ HTML::script('js/daterangepicker.js') }}

    {{ HTML::script('js/accounting.min.js')}}

    {{ HTML::script('js/app.js') }}

    {{ HTML::script('js/blueimp-gallery.min.js') }}
    {{ HTML::script('js/jquery.blueimp-gallery.min.js') }}


        <script src="{{ URL::to('sm')}}/js/jquery.cookie.js"></script>
        <script src='{{ URL::to('sm')}}/js/fullcalendar.min.js'></script>
        <script src="{{ URL::to('sm')}}/js/excanvas.js"></script>

        <script src="{{ URL::to('sm')}}/js/jquery.flot.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.flot.pie.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.flot.stack.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.flot.resize.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.flot.time.js"></script>

        <script src="{{ URL::to('sm')}}/js/jquery.chosen.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.uniform.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.cleditor.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.noty.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.elfinder.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.raty.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.iphone.toggle.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.uploadify-3.1.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.gritter.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.imagesloaded.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.masonry.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.knob.modified.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.sparkline.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/counter.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/raphael.2.1.0.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/justgage.1.0.1.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.autosize.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/retina.js"></script>
        <script src="{{ URL::to('sm')}}/js/jquery.placeholder.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/wizard.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/core.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/charts.min.js"></script>
        <script src="{{ URL::to('sm')}}/js/custom.min.js"></script>

        {{ HTML::script('js/jquery-fileupload/vendor/jquery.ui.widget.js') }}

        {{ HTML::script('js/js-load-image/load-image.min.js') }}

        {{ HTML::script('js/jquery.slimscroll.min.js') }}

        {{ HTML::script('js/js-canvas-to-blob/canvas-to-blob.min.js') }}

        {{ HTML::script('js/jquery-fileupload/jquery.iframe-transport.js') }}

        {{ HTML::script('js/jquery-fileupload/jquery.fileupload.js') }}

        {{ HTML::script('js/tinycolor-0.9.15.min.js')}}
        {{ HTML::script('js/pickacolor/pick-a-color-1.1.8.min.js') }}

        {{ HTML::script('js/jquery-fileupload/jquery.fileupload-process.js') }}
        {{ HTML::script('js/jquery-fileupload/jquery.fileupload-image.js') }}
        {{ HTML::script('js/jquery-fileupload/jquery.fileupload-audio.js') }}
        {{ HTML::script('js/jquery-fileupload/jquery.fileupload-video.js') }}
        {{ HTML::script('js/jquery-fileupload/jquery.fileupload-validate.js') }}

    <!-- end: JavaScript-->

</body>
</html>