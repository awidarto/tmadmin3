@extends('layout.formthree')

@section('left')
        <h4>Device Info</h4>
        {{ Former::hidden('id')->value($formdata['_id']) }}

        {{ Former::text('SKU','Asset Code') }}
        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

        {{ Former::select('assetType','Device Type')->options( Assets::getType()->TypeToSelection('type','type',true) ) }}

        {{ Former::select('locationId','Location')->id('location')->options( Assets::getLocation()->LocationToSelection('_id','name',true) ) }}
        {{ Former::select('rackId','Rack')->id('rack')->options( Assets::getRack()->RackToSelection('_id','SKU',true) ) }}
        {{ Former::text('itemDescription','Description') }}

        <h4>Owner & Person In Charge</h4>
        {{ Former::text('owner','Owner') }}

        {{ Former::text('PIC','Person In Charge') }}

        {{ Former::text('PIC','PIC Phone') }}
        {{ Former::text('PIC','PIC Email') }}

        {{ Former::text('contractNumber','Contract Number') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

@stop

@section('middle')
        <h4>Host Info</h4>
        {{ Former::text('IP','IP Address') }}
        {{ Former::text('hostName','Host Name') }}
        {{ Former::text('OS','Operating System') }}
        <h4>Status</h4>

        {{ Former::select('powerStatus')->label('Power Status')->options(array('1'=>'Yes','0'=>'No')) }}
        {{ Former::select('labelStatus')->label('Label Status')->options(array('1'=>'Yes','0'=>'No')) }}
        {{ Former::select('virtualStatus')->label('Virtual Status')->options(array('1'=>'Yes','0'=>'No')) }}
@stop

@section('right')
        <h4>Pictures</h4>
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