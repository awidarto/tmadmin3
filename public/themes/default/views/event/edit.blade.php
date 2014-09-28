@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row-fluid">
    <div class="col-md-6">
        {{ Former::text('title','Event Title') }}
        {{ Former::text('slug','Permalink')->id('permalink') }}
        {{ Former::text('venue','Venue') }}
        {{ Former::text('location','Location') }}


        {{ Former::text('fromDate','From')->class('span7 eventdate')
            ->id('fromDate')
            //->data_format('dd-mm-yyyy')
            ->append('<i class="fa fa-th"></i>') }}

        {{ Former::text('toDate','Until')->class('span7 eventdate')
            ->id('toDate')
            //->data_format('dd-mm-yyyy')
            ->append('<i class="fa fa-th"></i>') }}

        {{ Former::select('category')->options(Config::get('ia.eventcat'))->label('Category') }}
        {{ Former::textarea('description','Description') }}
        {{ Former::text('tags','Tags')->class('tag_keyword') }}

    </div>
    <div class="col-md-6">
        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make($formdata) }}


        @for($i = 1;$i < 6;$i++)
            <div class="row form-horizontal">
                <div class="col-md-4">
                    {{ Former::text('code_'.$i,'Code '.$i)->class('col-md-12')->maxlength('6') }}
                </div>
                <div class="col-md-4">
                    {{ Former::text('val_'.$i,'Value '.$i)->class('col-md-12')->maxlength('6') }}
                </div>
            </div>
        @endfor
        {{ Former::text('expires','Expires')->class('span7 datepicker')
            ->id('expires')
            //->data_format('dd-mm-yyyy')
            ->append('<i class="fa fa-th"></i>') }}
    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">
        {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>

{{Former::close()}}

<script type="text/javascript">


$(document).ready(function() {

    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('.eventdate').on('apply',function(ev,picker){
        console.log(moment( picker.endDate ,'MM/DD/YYYY'));
        $('#expires').val( picker.endDate.add('weeks',2).format('MM/DD/YYYY') );
    });

});

</script>

@stop