@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>


{{Former::open_for_files_horizontal($submit,'POST',array('class'=>'custom'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row">
    <div class="col-md-6">

        {{ Former::text('SKU','Asset Code') }}
        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

        {{ Former::select('locationId','Location')->options( Assets::getLocation()->LocationToSelection('_id','name',true) ) }}
        {{ Former::text('itemDescription','Description') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

    </div>
    <div class="col-md-6">

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make($formdata) }}

    </div>
</div>

<div class="row right">
    <div class="col-md-12">
        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}


<script type="text/javascript">

$(document).ready(function() {

    $('.pick-a-color').pickAColor({
        showHexInput:false
    });

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop