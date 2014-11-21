@extends('layout.formthree')


@section('left')

{{ Former::hidden('id')->value($formdata['_id']) }}
        <h5>Location Info</h5>
        {{ Former::text('name','Name') }}
        {{ Former::text('slug','Permalink')->id('permalink') }}
        {{ Former::text('venue','Venue') }}
        {{ Former::text('address','Address') }}
        {{ Former::text('phone','Phone') }}
@stop

@section('middle')
    <h5>Geo Point ( for Google Map Marker )</h5>
    {{ Former::text('latitude','Latitude') }}
    {{ Former::text('longitude','Longitude') }}
@stop

@section('right')
    {{ Former::select('category')->options(Config::get('asset.location_category'))->label('Category') }}
    {{ Former::textarea('description','Description')->class('editor form-control') }}
    {{ Former::text('tags','Tags')->class('tag_keyword') }}
</div>

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