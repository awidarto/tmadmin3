<!DOCTYPE html>
<html class="no-js">

<head>
    <!-- Some assets concatenated and minified to improve load speed. Download version includes source css, javascript and less assets -->
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="Flat, Clean, Responsive, admin template built with bootstrap 3">
    <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1, maximum-scale=1">

    <title>{{ Config::get('site.name') }}</title>

    <!-- bootstrap -->
    {{ HTML::style('bootflat/css/site.min.css')}}
    <!-- /bootstrap -->

    <!-- page styles -->
    @include('layout.css')
    <!-- /page styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="{{ URL::to('cameo') }}/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="{{ URL::to('cameo') }}/https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    {{ HTML::script('bootflat/js/site.min.js')}}
    <style type="text/css">
        .bg-dark{
            background-color: #8b1a1a;
        }
    </style>

</head>

<body class="bg-dark">
    <div class="app-user">
        <div class="container">
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

                </div>
                <div  class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="display:table;">
                    <div class="panel panel-primary" style="margin-top:100px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $title }}</h3>
                        </div>
                        <div class="panel-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
