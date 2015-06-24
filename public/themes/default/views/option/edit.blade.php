@extends('layout.fixedtwo')


@section('left')

    {{ Former::hidden('id')->value($formdata['_id']) }}
    {{ Former::text('value', $formdata['label'] ) }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('aux')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop


