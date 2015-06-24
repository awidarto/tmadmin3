@extends('layout.fixedtwo')

@section('left')
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
    */

    var editor = new wysihtml5.Editor("body", { // id of textarea element
      toolbar:      "wysihtml5-toolbar", // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });

    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop