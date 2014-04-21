@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row-fluid">
    <div class="span6">

        {{ Former::text('SKU','SKU') }}
        {{ Former::text('category','Category') }}
        {{ Former::text('series','Series') }}
        {{ Former::text('itemDescription','Description') }}
        {{ Former::text('itemGroup','Item Group')->help('for compound product only') }}
        {{ Former::text('priceRegular','Regular Price')->class('span4') }}
        {{ Former::text('material','Material') }}
        {{ Former::text('colour','Colour')->class('span4') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

        <div class="row-fluid form-vertical">
            <div class="span4">
                {{ Former::text('W','Width')->class('span12')}}
            </div>
            <div class="span4">
                {{ Former::text('H','Height')->class('span12') }}
            </div>
            <div class="span4">
                {{ Former::text('L','Length')->class('span12') }}
            </div>
        </div>
        <div class="row-fluid form-vertical">
            <div class="span4">
                {{ Former::text('D','Diameter')->class('span12')}}
            </div>
            <div class="span4">
                {{ Former::text('sizeDescription','Dimension Description') }}
            </div>
        </div>

    </div>
    <div class="span6">
        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make($formdata) }}

    </div>
</div>

<div class="row-fluid right">
    <div class="span12">
        {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<script type="text/javascript">


$(document).ready(function() {


    function setVisibleOptions(){
        var mc = $('#mainCategory').val();

        console.log(mc);

        if( mc == 'Structure'){
            $('#productFunction').hide();
            $('#productSystem').show();
            $('#productApplication').hide();
        }else if( mc == 'Furniture'){
            $('#productFunction').show();
            $('#productSystem').hide();
            $('#productApplication').hide();
        }else{
            $('#productFunction').hide();
            $('#productSystem').hide();
            $('#productApplication').show();
        }

    }

    setVisibleOptions();

    $('select').select2({
      width : 'resolve'
    });

    $('.pick-a-color').pickAColor();

    var url = '{{ URL::to('upload') }}';

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $('#progress .bar').css(
                'width',
                '0%'
            );

            $.each(data.result.files, function (index, file) {
                var thumb = '<li><img src="' + file.thumbnail_url + '" /><input type="radio" name="defaultpic" value="' + file.name + '"> Default<br /><span class="img-title">' + file.name + '</span>' +
                '<label for="caption">Caption</label><input type="text" name="caption[]" />' +
                '<label for="material">Material & Finish</label><input type="text" name="material[]" />' +
                '<label for="tags">Tags</label><input type="text" name="tag[]" />' +
                '</li>';
                $(thumb).appendTo('#files ul');

                var upl = '<input type="hidden" name="delete_type[]" value="' + file.delete_type + '">';
                upl += '<input type="hidden" name="delete_url[]" value="' + file.delete_url + '">';
                upl += '<input type="hidden" name="filename[]" value="' + file.name  + '">';
                upl += '<input type="hidden" name="filesize[]" value="' + file.size  + '">';
                upl += '<input type="hidden" name="temp_dir[]" value="' + file.temp_dir  + '">';
                upl += '<input type="hidden" name="thumbnail_url[]" value="' + file.thumbnail_url + '">';
                upl += '<input type="hidden" name="filetype[]" value="' + file.type + '">';
                upl += '<input type="hidden" name="fileurl[]" value="' + file.url + '">';

                $(upl).appendTo('#uploadedform');

            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    })
    .prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#field_role').change(function(){
        //alert($('#field_role').val());
        // load default permission here
    });

    /*
    var editor = new wysihtml5.Editor('ecofriendly', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    //$('#color_input').colorPicker();

    // dynamic tables
    $('#add_btn').click(function(){
        //alert('click');
        addTableRow($('#variantTable'));
        return false;
    });

    // custom field table
    $('#custom_add_btn').click(function(){
        //alert('click');
        addTableRow($('#customTable'));
        return false;
    });

    $('#related_add_btn').click(function(){
        //alert('click');
        addTableRow($('#relatedTable'));
        return false;
    });

    $('#component_add_btn').click(function(){
        //alert('click');
        addTableRow($('#componentTable'));
        return false;
    });

    $('#mainCategory').change(function(){
        setVisibleOptions();
    });

});

</script>

@stop