@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

<div class="row-fluid">
    <div class="col-md-6">
        {{ Former::file('inputfile','Select file ( .xls, .xlsx )') }}

        {{ Former::hidden( 'controller',$back ) }}
        {{ Former::hidden( 'importkey',$importkey ) }}

        {{ Former::text('headindex','Row containing header')->class('col-md-2')->value(2) }}
        {{ Former::text('firstdata','Data starting at row')->class('col-md-2')->value(3) }}

    </div>
    <div class="col-md-6">

    </div>
</div>

<div class="row-fluid right">
    <div class="col-md-12">
        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}

<script type="text/javascript">


$(document).ready(function() {


    $('select').select2({
      width : 'resolve'
    });



});

</script>

@stop