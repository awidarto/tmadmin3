@extends('layout.fixedtwo')

@section('left')
    {{ Former::textarea('body','Body')->name('body')->class('code form-control')->id('body')->style('min-height:600px;') }}
    {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
@stop

@section('right')

    {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}
    {{ Former::text('title','Title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::select('category')->options(Prefs::getCategory()->catToSelection('title','title'))->label('Category') }}
    {{ Former::text('tags','Tags')->class('tag_keyword') }}
    {{ Former::text('properties','Products to be featured')->class('tag_property form-control') }}

    <?php
        $fupload = new Fupload();
    ?>

    {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make() }}

@stop


@section('aux')

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}

</style>

{{ HTML::script('js/ace/ace.js') }}
{{ HTML::script('js/ace/theme-twilight.js') }}
{{ HTML::script('js/ace/mode-php.js') }}
{{ HTML::script('js/jquery-ace.min.js') }}


{{-- HTML::script('js/codemirror/lib/codemirror.js') --}}
{{-- HTML::script('js/codemirror/mode/php/php.js') --}}
{{-- HTML::script('js/codemirror/mode/xml/xml.js') --}}


{{-- HTML::style('css/summernote-bs2.css') --}}
{{-- HTML::style('css/summernote.css')--}}
{{-- HTML::style('css/summernote-bp.css')--}}
{{-- HTML::script('js/summernote.min.js') --}}

{{-- HTML::style('js/codemirror/lib/codemirror.css') --}}
{{-- HTML::style('js/codemirror/theme/twilight.css') --}}

<script type="text/javascript">


$(document).ready(function() {


    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('.code').ace({ theme: 'twilight', lang: 'php' });

    /*
    $('#body').summernote({
        height:'600px',
        codemirror: {
            'theme':'twilight',
            'mode':'php'
        }
    });
    */


});

</script>

@stop