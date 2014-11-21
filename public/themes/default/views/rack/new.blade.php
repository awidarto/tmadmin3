@extends('layout.form')


@section('left')

    {{ Former::text('SKU','Asset Code') }}
    {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

    {{ Former::select('locationId','Location')->options( Assets::getLocation()->LocationToSelection('_id','name',true) ) }}
    {{ Former::text('itemDescription','Description') }}

    {{ Former::text('tags','Tags')->class('tag_keyword') }}

@stop

@section('right')

    <h5>Pictures</h5>
    <?php
        $fupload = new Fupload();
    ?>
    {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')
        ->url('upload')
        ->singlefile(false)
        ->prefix('assetpic')->multi(true)->make() }}

@stop


@section('aux')


<script type="text/javascript">


$(document).ready(function() {


    $('.pick-a-color').pickAColor();

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

});

</script>

@stop