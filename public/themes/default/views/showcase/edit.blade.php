@extends('layout.fixedtwo')

@section('left')
    {{ Former::hidden('id')->value($formdata['_id']) }}

    {{ Former::textarea('body','Body')->name('body')->id('body')->style('min-height:600px;') }}
    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}
        {{ Former::text('title','Title') }}
        {{ Former::text('slug','Permalink')->id('permalink') }}


        {{ Former::text('tags','Content Filter Tags')->class('tag_keyword')->help('Use tags to extract show case content from Posts') }}

        <h4>Categorization</h4>
        {{ Former::select('criteria')->options(array('year'=>'By Year','category'=>'By Category'))->label('Cluster') }}

        {{ Former::select('yearFrom')->options(Prefs::yearSelection())->selected( date('Y',time()))->label('From Year') }}
        {{ Former::select('yearTo')->options(Prefs::yearSelection())->selected(date('Y',time()))->label('To Year') }}

        {{ Former::select('category')->options(Prefs::getCategory()->catToSelection('slug','title'))->label('Category') }}

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make($formdata) }}

@stop

@section('aux')

{{-- HTML::script('js/ace/ace.js') --}}
{{-- HTML::script('js/ace/theme-twilight.js') --}}
{{-- HTML::script('js/ace/mode-php.js') --}}
{{-- HTML::script('js/jquery-ace.min.js') --}}


{{ HTML::script('js/codemirror/lib/codemirror.js') }}
{{ HTML::script('js/codemirror/mode/php/php.js') }}
{{ HTML::script('js/codemirror/mode/xml/xml.js') }}

{{ HTML::style('css/summernote-bs2.css') }}
{{ HTML::style('css/summernote.css')}}
{{ HTML::style('css/summernote-bp.css')}}
{{ HTML::script('js/summernote.min.js') }}

{{ HTML::style('js/codemirror/lib/codemirror.css') }}
{{ HTML::style('js/codemirror/theme/twilight.css') }}


<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}

</style>

<script type="text/javascript">

$(document).ready(function() {

    $('#body').summernote({
        height:'600px',
        codemirror: {
            'theme':'twilight',
            'mode':'php'
        }
    });

    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

});

</script>

@stop