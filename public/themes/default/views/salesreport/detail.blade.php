@extends('layout.print')

@section('content')
<h4>Purchase Detail</h4>
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
