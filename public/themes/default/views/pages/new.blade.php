@extends('layout.fixedtwo')


@section('left')

{{Former::open_for_files_vertical($submit,'POST',array('class'=>''))}}


<div class="row-fluid">

    {{ Former::textarea('body','Body')->name('body')->id('body')->style('min-height:600px;') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

</div>

@stop

@section('right')
    {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}
    {{ Former::text('title','Title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::select('section')->options(Prefs::getSection()->sectionToSelection('slug','title'))->label('Section') }}
    {{ Former::select('category')->options(Prefs::getCategory()->catToSelection('slug','title'))->label('Category') }}
    {{ Former::text('tags','Tags')->class('tag_keyword') }}

    <?php
        $fupload = new Fupload();
    ?>

    {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make() }}

<div class="row-fluid">
    <div class="col-md-12 pull-right">
    </div>
</div>

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