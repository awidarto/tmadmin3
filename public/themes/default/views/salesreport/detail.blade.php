@extends('layout.print')

@section('content')
<h2>Purchase Detail</h2>
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
@endsection
