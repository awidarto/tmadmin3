@extends('layout.print')

@section('content')
<style type="text/css">
    table.table td{
        line-height: 0.9em !important;
    }

</style>
<table style="width:100%;margin-top:10px;">
    <tr>
        <td>
            <img src="{{ URL::to('images')}}/tmlogotrans.png" style="width: 129px; height: 38.27px;">
            <div>
              <address>
                  <strong>Toimoi Indonesia</strong>
                    <br />The Mansion Kemang GF15
                    <br />Jl Kemang Raya no. 3-5
                    <br />Jakarta Selatan 12730
                    <br />Indonesia
                    <br />p. +62 21 29055525  f. +62 21 29055526
              </address>
            </div>

        </td>
        <td>
            <div class="pull-right text-right">
                <h3>Purchase Detail</h3>
                <p>Date : {{ date('d-m-Y',$sales['payment']['createdDate']->sec)}}</p>
                <h5 class="text-uppercase">Invoice # : {{ $sales['payment']['invoice_number'] }}</h5>
            </div>

        </td>
    </tr>
</table>
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        {{ $tablebuyer }}
    </div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        {{ $tabletrans}}
    </div>
</div>
{{--

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{ $tableshipment}}
    </div>
</div>

--}}

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
