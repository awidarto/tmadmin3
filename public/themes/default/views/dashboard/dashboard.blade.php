@extends('layout.fixed')

@section('content')

                <div class="content-wrap">

                    <div class="row mg-b">
                        <div class="col-xs-6">
                            <h3 class="no-margin">Dashboard</h3>
                            <small>Welcome back, {{ Auth::user()->fullname }}</small>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="#" class="fa fa-flash pull-right pd-sm toggle-chat toggle-sidebar" data-toggle="off-canvas" data-move="rtl">
                                <span class="badge bg-danger animated flash">6</span>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="circle-icon bg-success">
                                        <i class="fa fa-microphone"></i>
                                    </div>
                                    <div>
                                        <h3 class="no-margin">5468</h3>
                                        New signups
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="circle-icon bg-danger">
                                        <i class="fa fa-anchor"></i>
                                    </div>
                                    <div>
                                        <h3 class="no-margin">2,300</h3>
                                        Total equity
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="circle-icon bg-default">
                                        <i class="fa fa-magnet"></i>
                                    </div>
                                    <div>
                                        <h3 class="no-margin">3,823</h3>
                                        Views today
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="circle-icon">
                                        <canvas id="icon1" width="50" height="50"></canvas>
                                    </div>
                                    <div>
                                        <h3 class="no-margin">12&#176;</h3>
                                        Fog Overcast
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <section class="panel no-border dashboard-chart">
                                        <div class="panel-heading no-border pd-b-lg">
                                            <small class="show pd-b">MESSAGE ANALYTICS
                                                <i class="pull-right">
                                                    <a class="fa fa-chevron-down panel-collapsible pd-r-xs" href="#"></a>
                                                    <a class="fa fa-refresh panel-refresh pd-r-xs" href="#"></a>
                                                    <a class="fa fa-times panel-remove" href="#"></a>
                                                </i>
                                                <br>Weekly Stats
                                            </small>
                                        </div>
                                        <div class="panel-body no-padding">
                                            <div id="line" style="height:160px;margin: 0 -25px -25px;"></div>
                                        </div>
                                        <div class="panel-footer text-center no-border no-padding bg-none">
                                            <div class="row text-center">
                                                <div class="col-xs-6 col-sm-3">
                                                    <i class="fa fa-circle text-default"></i>
                                                    <span class="h4 mg-r-xs">5,687</span>
                                                    <small class="text-muted">Sent mail</small>
                                                </div>
                                                <div class="col-xs-6 col-sm-3">
                                                    <i class="fa fa-circle text-primary"></i>
                                                    <span class="h4 mg-r-xs">78,694</span>
                                                    <small class="text-muted">Received</small>
                                                </div>
                                                <div class="col-xs-6 col-sm-3">
                                                    <span class="h4 mg-r-xs">12,095</span>
                                                    <small class="text-muted">Pending</small>
                                                </div>
                                                <div class="col-xs-6 col-sm-3">
                                                    <span class="h4 mg-r-xs">9,427</span>
                                                    <small class="text-muted">Outbound</small>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <section class="panel panel-primary">
                                        <div class="panel-heading">People you may know
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="pull-left mg-t-xs mg-r-md">
                                                    <img src="img/face3.jpg" class="avatar avatar-sm img-circle" alt="">
                                                </span>
                                                <div class="show no-margin pd-t-xs">
                                                    Gary Stone
                                                    <small class="pull-right">1,244 Followers</small>
                                                </div>
                                                <small class="text-muted">Friends with Kevin Hanson</small>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-left mg-t-xs mg-r-md">
                                                    <img src="img/face5.jpg" class="avatar avatar-sm img-circle" alt="">
                                                </span>
                                                <div class="show no-margin pd-t-xs">
                                                    Taylor King
                                                    <small class="pull-right">1,244 Followers</small>
                                                </div>
                                                <small class="text-muted">Friends with Kevin Hanson</small>
                                            </li>
                                        </ul>
                                    </section>
                                </div>

                    </div>
                </div>


@stop