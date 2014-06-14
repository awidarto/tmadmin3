@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row-fluid">
    <div class="span6">

        {{ Former::text('company','Company Name')->required() }}

        {{ Former::text('address_1','Address')->required() }}
        {{ Former::text('address_2','') }}
        {{ Former::text('city','City')->required() }}
        {{ Former::text('zipCode','ZIP / Postal Code')->id('zip')->class('span2')->maxlength(5)->required() }}
        <div class="us" style="{{ ($formdata['countryOfOrigin'] == 'United States of America')?'':'display:none;' }}">
            {{ Former::select('state')->class('us')->options(Config::get('country.us_states'))->label('State')->id('us_states')
                ->style(($formdata['countryOfOrigin'] == 'United States of America')?false:true)
                ->disabled(($formdata['countryOfOrigin'] == 'United States of America')?false:true)
            }}
        </div>
        <div class="au" style="{{ ($formdata['countryOfOrigin'] == 'Australia')?'':'display:none;' }}">
            {{ Former::select('state')->class('au')->options(Config::get('country.aus_states'))->label('State')->id('au_states')
                ->style(($formdata['countryOfOrigin'] == 'Australia')?'':'display:none;')
                ->disabled(($formdata['countryOfOrigin'] == 'Australia')?false:true)
            }}
        </div>
        <div class="outside" style="{{ ($formdata['countryOfOrigin'] == 'Australia' || $formdata['countryOfOrigin'] == 'United States of America' )?'display:none':''; }}">
            {{ Former::text('state','State / Province')->class('outside span3')->id('other_state')
                ->style(($formdata['countryOfOrigin'] == 'Australia' || $formdata['countryOfOrigin'] == 'United States of America')?'display:none;':'')
                ->disabled(($formdata['countryOfOrigin'] == 'Australia' || $formdata['countryOfOrigin'] == 'United States of America')?true:false)
            }}
        </div>

        {{ Former::select('countryOfOrigin')->id('country')->options(Config::get('country.countries'))->label('Country of Origin') }}
    </div>
    <div class="span6">

    </div>
</div>

<div class="row-fluid right">
    <div class="span12">
        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<script type="text/javascript">


$(document).ready(function() {

    $('#country').on('change',function(){
        var country = $('#country').val();

        if(country == 'Australia'){
            $('.au').show();
            $('.us').hide();
            $('.outside').hide();

            $('select.au').removeProp('disabled');
            $('select.us').prop('disabled','disabled');
            $('input.outside').prop('disabled','disabled');

        }else if(country == 'United States of America'){
            $('.au').hide();
            $('.us').show();
            $('.outside').hide();

            $('select.au').prop('disabled','disabled');
            $('select.us').removeProp('disabled');
            $('input.outside').prop('disabled','disabled');
        }else{
            $('.au').hide();
            $('.us').hide();
            $('.outside').show();

            $('select.au').prop('disabled','disabled');
            $('select.us').prop('disabled','disabled');
            $('input.outside').removeProp('disabled');
        }


    });

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
                var thumb = '<li><img src="' + file.thumbnail_url + '" /><br /><input type="radio" name="defaultpic" value="' + file.name + '"> Default<br /><span class="img-title">' + file.name + '</span>' +
                '<label for="colour">Colour</label><input type="text" name="colour[]" />' +
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

});

</script>

@stop