@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>''))}}

<div class="row-fluid">
    <div class="span6">
        {{ Former::text('name','Outlet Name') }}
        {{ Former::text('slug','Permalink')->id('permalink') }}
        {{ Former::text('venue','Venue') }}
        {{ Former::text('address','Address') }}
        {{ Former::text('phone','Phone') }}

    </div>
    <div class="span6">
        {{ Former::select('category')->options(Config::get('tm.outlet_category'))->label('Outlet Category') }}
        {{ Former::textarea('description','Description')->class('editor') }}
        {{ Former::text('tags','Tags')->class('tag_keyword') }}
    </div>
</div>

<div class="row-fluid">
    <div class="span12 pull-right">
        {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>

{{Former::close()}}

<script type="text/javascript">

$(document).ready(function() {

    $('select').select2({
      width : 'resolve'
    });

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

});

</script>

@stop