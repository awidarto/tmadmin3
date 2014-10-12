@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom'))}}

<div class="row-fluid">
    <div class="col-md-6">

        {{ Former::text('SKU','Asset Code') }}
        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

        {{ Former::select('assetType','Asset Type')->id('rack')->options( Assets::getType()->TypeToSelection('type','type',true) ) }}

        {{ Former::select('locationId','Location')->id('location')->options( Assets::getLocation()->LocationToSelection('_id','name',true) ) }}
        {{ Former::select('rackId','Rack')->id('rack')->options( Assets::getRack()->RackToSelection('_id','SKU',true) ) }}
        {{ Former::text('itemDescription','Description') }}

        {{ Former::text('IP','IP Address')->class('col-md-4 form-control') }}

        {{ Former::text('owner','Owner') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

    </div>
    <div class="col-md-6">

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make() }}

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


    $('.pick-a-color').pickAColor();

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('#location').on('change',function(){
        var location = $('#location').val();
        console.log(location);

        $.post('{{ URL::to('asset/rack' ) }}',
            {
                loc : location
            },
            function(data){
                var opt = updateselector(data.html);
                $('#rack').html(opt);
            },'json'
        );

    })

    function updateselector(data){
        var opt = '';
        for(var k in data){
            opt += '<option value="' + k + '">' + data[k] +'</option>';
        }
        return opt;
    }


});

</script>

@stop