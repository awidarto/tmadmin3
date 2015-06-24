@extends('layout.print')

@section('content')
<h4>Purchase Detail</h4>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {{ $tablebuyer }}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {{ $tablepurchase }}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{ $tabletrans}}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
