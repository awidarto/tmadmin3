@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row-fluid">
    <div class="span6">
        {{ Former::text('videoTitle','Title') }}
        {{ Former::text('url','Youtube URL') }}
        {{ Former::text('tags','Tags')->class('tag_keyword') }}
    </div>
    <div class="span6">


    </div>
</div>

<div class="row-fluid">
    <div class="span12">
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