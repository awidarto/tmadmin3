@extends('layout.fixedtwo')


@section('left')
    {{ Former::text('widgetLocation','Widget Location')->class('wlocautocomplete form-control')->help('Group slides in the same location / position in page') }}

    {{ Former::text('linkTo','Link to')->help('Link to URL on click event ( local controller or absolute URL )') }}

    {{ Former::select('slidetype')->options( Config::get('ia.slidetype') )->label('Type')->required() }}
    {{ Former::text('sequence','Sequence')->value(1)->help('ascending display sequence') }}
    {{ Former::select('publishing')->options(array('unpublished'=>'Unpublished','published'=>'Published'))->label('Status') }}

    <h6>Video</h6>
    {{ Former::text('videoTitle','Title') }}
    {{ Former::text('youtubeUrl','Youtube ID') }}

    <h6>Content</h6>
    {{ Former::textarea('content','HTML Content')->class('col-md-10 editor')->rows(8)->help('Use HTML tags to format content') }}

    {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
    <h6>Image</h6>
    <?php
        $fupload = new Fupload();
    ?>

    {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->url('upload/slide')->make() }}

@stop

@section('aux')
    {{ HTML::script('js/codemirror/lib/codemirror.js') }}
    {{ HTML::script('js/codemirror/mode/php/php.js') }}
    {{ HTML::script('js/codemirror/mode/xml/xml.js') }}

    {{ HTML::style('css/summernote-bs2.css') }}
    {{ HTML::style('css/summernote.css')}}
    {{ HTML::style('css/summernote-bp.css')}}
    {{ HTML::script('js/summernote.min.js') }}

    {{ HTML::style('js/codemirror/lib/codemirror.css') }}
    {{ HTML::style('js/codemirror/theme/twilight.css') }}

    <script type="text/javascript">

    $(document).ready(function() {

        $('.editor').summernote({
            height:'300px',
            codemirror: {
                'theme':'twilight',
                'mode':'php'
            }
        });


        $('.wlocautocomplete').autocomplete({
            source: base + 'homeslide/location'
        });

    });

    </script>

@stop
