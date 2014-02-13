@extends('layout.front')


@section('content')

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

<div class="row-fluid">
    <div class="span6">
        {{ Former::text('productName','Name')->class('span12') }}

        {{ Former::select('productCategory')->options(Prefs::getProductCategory()->ProductCatToSelection('title','title'))->label('Category') }}

        {{ Former::textarea('description','Description')->class('span10')->rows(8) }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

        {{ Form::submit('Save',array('name'=>'submit','class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

    </div>
    <div class="span6">
        {{ Former::select('productOutlet')->options(Prefs::getOutlet()->OutletToSelection('slug','name'))->label('Outlet') }}
        <div class="row-fluid form-vertical">
            <div class="span4">
                {{ Former::text('width','Width')->class('span12') }}
            </div>
            <div class="span4">
                {{ Former::text('height','Height')->class('span12') }}
            </div>
            <div class="span4">
                {{ Former::text('length','Length')->class('span12') }}
            </div>
        </div>

        <div class="row-fluid form-vertical">
            <div class="span8">
                {{ Former::text('color','Color')->class('span8') }}
            </div>
            <div class="span4">
                {{ Former::text('quantity','Qty')->class('span8') }}
            </div>
        </div>

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->url('upload/product')->make() }}


    </div>
</div>

<div class="row-fluid pull-right">
    <div class="span4">
    </div>
</div>
{{Former::close()}}

{{ HTML::style('css/jquery-gmaps-latlon-picker.css')}}

{{ HTML::script('js/jquery-gmaps-latlon-picker.js')}}

<script type="text/javascript">

$(document).ready(function() {
    /*
    $('select').select2({
      width : 'resolve'
    });
    */

});

</script>

@stop