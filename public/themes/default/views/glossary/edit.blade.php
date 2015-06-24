@extends('layout.fixedtwo')

@section('left')
    {{ Former::hidden('id')->value($formdata['_id']) }}
    {{ Former::text('title','Title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::select('category')->options(Prefs::getFAQCategory()->FAQcatToSelection('title','title'))->label('Category') }}
    {{ Former::textarea('body','Body')->class('editor form-control')->name('body') }}

    {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
    {{ Former::text('tags','Tags')->class('tag_keyword') }}

@stop


@section('aux')

<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}
</style>

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<script type="text/javascript">


$(document).ready(function() {
    /*
    $('select').select2({
      width : 'resolve'
    });
    var editor = new wysihtml5.Editor("body", { // id of textarea element
      toolbar:      "wysihtml5-toolbar", // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */

    var url = '{{ URL::to('upload') }}';
    var murl = '{{ URL::to('upload/music') }}';

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

    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop