@extends('layout.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}


<div class="row-fluid">
    <div class="span6">

        {{ Former::text('propertyId','Property ID')->class('span4') }}

        {{ Former::select('state')->options(Config::get('country.us_states'))->label('States') }}
        {{ Former::text('number','Number')->class('span3') }}
        {{ Former::text('address','Address') }}
        {{ Former::text('city','City') }}
        {{ Former::text('zipCode','ZIP')->class('span2')->maxlength(5) }}


        <?php Former::framework('Nude');?>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span3">
                {{ Former::select('type')->options(Config::get('ia.type'))->label('Type')->class('span1') }}
            </div>
            <div class="span3">
                {{ Former::text('yearBuilt','Year Built')->class('span6')->maxlength(4)  }}
            </div>
        </div>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span3">
                {{ Former::text('FMV','FMV')->class('span6') }}
            </div>
            <div class="span3">
                {{ Former::text('listingPrice','Listing Price')->class('span6') }}
            </div>
        </div>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span3">
                {{ Former::text('bed','# of Bedroom')->class('number-field') }}
            </div>
            <div class="span3">
                {{ Former::text('bath','# of Bathroom')->class('number-field') }}
            </div>
            <div class="span3">
                {{ Former::text('garage','# of Garage')->class('number-field') }}
            </div>
        </div>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span3">
                {{ Former::select('basement')->options(Config::get('ia.boolean'))->label('Basement')->class('span1') }}
            </div>
            <div class="span3">
                {{ Former::select('pool')->options(Config::get('ia.boolean'))->label('Pool')->class('span1') }}
            </div>
        </div>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span4">
                {{ Former::text('houseSize','House Size (SqFt)')->class('span6') }}
            </div>
            <div class="span4">
                {{ Former::text('lotSize','Lot Size (SqFt)')->class('span6') }}
            </div>
        </div>


        <?php Former::framework('TwitterBootstrap');?>


        {{ Former::text('typeOfConstruction','Type of Construction')->class('span5') }}


    </div>
    <div class="span6">

        {{ Former::select('category')->options(Config::get('ia.category'))->label('Category') }}
        {{ Former::text('monthlyRental','Monthly Rental')->class('span3') }}
        {{ Former::select('section8')->options(Config::get('ia.boolean'))->label('Section 8')->class('span1') }}
        {{ Former::text('leaseTerms','Lease Terms')->append('months')->class('span2')->maxlength(2) }}
        {{ Former::text('leaseStartDate','Lease Start Date')->class('span7 datepicker')
            ->data_format('dd-mm-yyyy')
            ->append('<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>') }}

        <?php Former::framework('Nude');?>

        <div class="row-fluid lmargin">
            <div class="span3"></div>
            <div class="span2">
                {{ Former::text('tax','Tax')->class('span6') }}
            </div>
            <div class="span3">
                {{ Former::text('insurance','Insurance')->class('span6') }}
            </div>
            <div class="span3">
                {{ Former::text('HOA','HOA')->class('span6') }}
            </div>
        </div>

        <?php Former::framework('TwitterBootstrap');?>

        {{ Former::text('propertyManager','Property Manager') }}


        {{ Former::textarea('specialConditionRemarks','Special Condition Remarks')->class('span10')->rows(8) }}

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make($formdata) }}

    </div>
</div>

<div class="row-fluid pull-right">
    <div class="span4">
        {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<script type="text/javascript">


$(document).ready(function() {

    $('select').select2({
      width : 'resolve'
    });

    $('#field_role').change(function(){
        //alert($('#field_role').val());
        // load default permission here
    });

    /*
    var editor = new wysihtml5.Editor('ecofriendly', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop