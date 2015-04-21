@extends('layout.print')

@section('content')

<h4>Purchase Detail</h4>

<div class="row">
    <div class="col-md-4">
        <img src="http://localhost/tmadmin2/public/storage/media/o7uF8zd1x940myp/tmlogotrans.png" style="width: 129px; height: 38.27px;">
        <div class="pull-left">
          <address>
              <strong>Toimoi Indonesia</strong>
                <br />The Mansion Kemang GF15
                <br />Jl Kemang Raya no. 3-5
                <br />Jakarta Selatan 12730
                <br />Indonesia
                <br />p. +62 21 29055525  f. +62 21 29055526
          </address>
        </div>

    </div>
    <div class="col-md-6">

        <div class="pull-right text-right">
          <p>{{ date('d-m-Y',$sales['payment']['createdDate']->sec)}}</p>
          <h4 class="text-uppercase">Invoice # : {{ $sales['payment']['invoice_number'] }}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        {{ $tablebuyer }}
    </div>
    <div class="col-md-1">
        &nbsp;
    </div>
    <div class="col-md-5">
        {{ $tablepurchase }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ $tabletrans}}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ $tableshipment}}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).ready(function() {
            $('#delivery_number').editable();

            $('#delivery_status').editable({
              value: 'pending',
              source: [
                    {value: 'pending', text: 'Pending'},
                    {value: 'processing', text: 'Processing'},
                    {value: 'delivery', text: 'Delivery'},
                    {value: 'delivered', text: 'Delivered'},
                    {value: 'returned', text: 'Returned'}
                 ]
            });

            $('#transactionstatus').editable({
              value: 'confirmed',
              source: [
                    {value: 'confirmed', text: 'Confirmed'},
                    {value: 'paid', text: 'Paid'},
                    {value: 'canceled', text: 'Canceled'},
                    {value: 'delivered', text: 'Delivered'},
                    {value: 'returned', text: 'Returned'}
                 ]
            });

        });

    });


</script>

@endsection
