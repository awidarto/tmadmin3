@extends('layout.fixedtwo')


@section('left')

    {{ Former::text('name','Outlet Name') }}
    {{ Former::text('code','Outlet Code / Initial') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::text('venue','Venue') }}
    {{ Former::text('address','Address') }}
    {{ Former::text('phone','Phone') }}

    <h6>Geo Point ( for Google Map Marker )</h6>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {{ Former::text('latitude','Latitude') }}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {{ Former::text('longitude','Longitude') }}
        </div>
    </div>

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
    {{ Former::select('category')->options(Config::get('tm.outlet_category'))->label('Outlet Category') }}
    {{ Former::textarea('description','Description') }}
    {{ Former::text('tags','Tags')->class('tag_keyword') }}
@stop

@section('aux')

<script type="text/javascript">


$(document).ready(function() {

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

});

</script>

@stop