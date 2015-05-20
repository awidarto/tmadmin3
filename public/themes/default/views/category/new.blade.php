@extends('layout.fixedtwo')


@section('left')
    {{ Former::text('title','Title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::select('section')->options(Prefs::getSection()->sectionToSelection('slug','title',false))->label('Section') }}

    {{ Former::textarea('description','Description') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')

@stop
@section('aux')

<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}
</style>

<script type="text/javascript">


$(document).ready(function() {
    /*
    $('select').select2({
      width : 'resolve'
    });
    var editor = new wysihtml5.Editor("description", { // id of textarea element
      toolbar:      "wysihtml5-toolbar", // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */


    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop