@extends('layout.print')

@section('content')
<!-- main content -->
        <div class="row-fluid">
            <div class="col-md-4">
                  <div class="pull-left">
                        <img src="http://localhost/tmadmin2/public/storage/media/o7uF8zd1x940myp/tmlogotrans.png" style="width: 129px; height: 38.27px;">
                      <address>
                          <strong>Toimoi Indonesia</strong>
                            <br />The Mansion Kemang GF15
                            <br />Jl Kemang Raya no. 3-5
                            <br />Jakarta Selatan 12730
                            <br />Indonesia
                            <br />p. +62 21 29055525  f. +62 21 29055526
                      </address>
                  </div>
                  <div class="pull-right text-right">
                      <p>{{ date('d-m-Y',$pay['createdDate']->sec)}}</p>
                      <h4 class="text-uppercase">Invoice # : {{ $pay['invoice_number'] }}</h4>
                  </div>
            </div>
            <div class="col-md-8">
                {{ $transtab }}
            </div>
         </div>
<!-- /main content -->
@stop