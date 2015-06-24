@extends('layout.fixedtwo')

@section('left')
    {{ Former::hidden('id')->value($formdata['_id']) }}

    {{ Former::text('title','Title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::select('publishing')->options(array('unpublished'=>'Unpublished','published'=>'Published'))->label('Status') }}

    {{ Former::textarea('body','HTML Content')->class('col-md-10 editor')->rows(8)->help('Use HTML tags to format content') }}
    {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')

    <h6>Image</h6>
    <?php
        $fupload = new Fupload();
    ?>

    {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->url('upload/slide')->make($formdata) }}

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