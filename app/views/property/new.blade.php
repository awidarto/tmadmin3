@extends('layout.front')


@section('content')


<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

<?php
/*
propertyStockID
state
number
address
city
zipCode
type
yearBuilt
FMV
listingPrice

equity
eqPercent

bed
bath
basement
garage
pool
houseSize
lotSize
typeOfConstruction

uSDsqft

monthlyRental
section8
leaseTerms
leaseStartDate
tax
insurance
HOA
category
propertyManager

annualRental
propertyManagementFee
maintenanceVacancyAllowance
onePctRule
rentalYield
capitalizationRate

specialConditionRemarks
*/
?>


<div class="row-fluid">
    <div class="span6">

        {{ Former::select('state')->options(Config::get('country.us_states'))->label('States') }}
        {{ Former::text('number','Number') }}
        {{ Former::text('address','Address') }}
        {{ Former::text('city','City') }}
        {{ Former::text('zipCode','ZIP') }}
        {{ Former::select('type')->options(Config::get('ia.type'))->label('Type')->class('span1') }}
        {{ Former::text('yearBuilt','Year Built') }}
        {{ Former::text('FMV','Fair Market Value') }}
        {{ Former::text('listingPrice','Listing Price') }}


        {{ Former::text('bed','# of Bedroom') }}
        {{ Former::text('bath','# of Bathroom') }}
        {{ Former::text('garage','# of Garage') }}

        {{ Former::select('basement')->options(Config::get('ia.boolean'))->label('Basement')->class('span1') }}
        {{ Former::select('pool')->options(Config::get('ia.boolean'))->label('Pool')->class('span1') }}

        {{ Former::text('houseSize','House Size (SqFt)') }}
        {{ Former::text('lotSize','Lot Size (SqFt)') }}
        {{ Former::text('typeOfConstruction','Type of Construction') }}


    </div>
    <div class="span6">

        {{ Former::select('category')->options(Config::get('ia.category'))->label('Category') }}
        {{ Former::text('monthlyRental','Monthly Rental') }}
        {{ Former::select('section8')->options(Config::get('ia.boolean'))->label('Section 8')->class('span1') }}
        {{ Former::text('leaseTerms','Lease Terms') }}
        {{ Former::text('leaseStartDate','Lease Start Date')->class('span7 datepicker')
            ->data_format('dd-mm-yyyy')
            ->append('<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>') }}



        {{ Former::text('tax','Tax') }}
        {{ Former::text('insurance','Insurance') }}
        {{ Former::text('HOA','HOA') }}
        {{ Former::text('propertyManager','Property Manager') }}


        @include('partials.editortoolbar')
        {{ Former::textarea('specialConditionRemarks','Special Condition Remarks') }}


    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <label class="control-label" for="userfile">Upload Images</label>
            <div class="controls">
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                </span>
                <br />
                <br />
                <div id="progress" class="progress progress-success progress-striped">
                    <div class="bar"></div>
                </div>
                <br />
                <div id="files" class="files">
                    <ul>
                        <?php
                            $allin = Input::old();
                            $showold = false;

                            if( count($allin) > 0){
                                $showold = true;
                            }

                            if($showold && isset( $allin['thumbnail_url'])){

                                $filename = $allin['filename'];
                                $thumbnail_url = $allin['thumbnail_url'];
                                $file_id = $allin['file_id'];

                                $thumb = '<li><img src="%s"><br /><input type="radio" name="defaultpic" value="%s" %s > Default<br />';
                                $thumb .= '<span class="img-title">%s</span>';
                                $thumb .= '</li>';

                                for($t = 0; $t < count($filename);$t++){
                                    if($allin['defaultpic'] == $filename[$t]){
                                        $isdef = 'checked="checked"';
                                    }else{
                                        $isdef = ' ';
                                    }

                                    printf($thumb,$thumbnail_url[$t],
                                        $file_id[$t],
                                        $isdef,
                                        $filename[$t],
                                        $allin['colour'][$t],$allin['material'][$t],$allin['tag'][$t]);
                                }

                            }
                        ?>
                    </ul>
                </div>
                <div id="uploadedform">
                    <?php

                        if($showold && isset( $allin['filename'] )){

                            $count = 0;
                            $upcount = count($allin['filename']);

                            $upl = '';
                            for($u = 0; $u < $upcount; $u++){
                                $upl .= '<input type="hidden" name="delete_type[]" value="' . $allin['delete_type'][$u] . '">';
                                $upl .= '<input type="hidden" name="delete_url[]" value="' . $allin['delete_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filename[]" value="' . $allin['filename'][$u]  . '">';
                                $upl .= '<input type="hidden" name="filesize[]" value="' . $allin['filesize'][$u]  . '">';
                                $upl .= '<input type="hidden" name="temp_dir[]" value="' . $allin['temp_dir'][$u]  . '">';
                                $upl .= '<input type="hidden" name="thumbnail_url[]" value="' . $allin['thumbnail_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filetype[]" value="' . $allin['filetype'][$u] . '">';
                                $upl .= '<input type="hidden" name="fileurl[]" value="' . $allin['fileurl'][$u] . '">';
                                $upl .= '<input type="hidden" name="file_id[]" value="' . $allin['file_id'][$u] . '">';
                            }

                            print $upl;
                        }

                    ?>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row-fluid pull-right">
    <div class="span12">
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

    var url = '{{ URL::to('upload') }}';

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                var thumb = '<li><img src="' + file.thumbnail_url + '" /><input type="radio" name="defaultpic" value="' + file.file_id + '"> Default<br /><span class="img-title">' + file.name + '</span>' +
                '<label for="caption">Caption</label><input type="text" name="caption[]" />' +
                //'<label for="material">Material & Finish</label><input type="text" name="material[]" />' +
                //'<label for="tags">Tags</label><input type="text" name="tag[]" />' +
                '</li>';
                $(thumb).appendTo('#files ul');

                var upl = '<input type="hidden" name="delete_type[]" value="' + file.delete_type + '">';
                upl += '<input type="hidden" name="delete_url[]" value="' + file.delete_url + '">';
                upl += '<input type="hidden" name="filename[]" value="' + file.name  + '">';
                upl += '<input type="hidden" name="filesize[]" value="' + file.size  + '">';
                upl += '<input type="hidden" name="temp_dir[]" value="' + file.temp_dir  + '">';
                upl += '<input type="hidden" name="thumbnail_url[]" value="' + file.thumbnail_url + '">';
                upl += '<input type="hidden" name="filetype[]" value="' + file.type + '">';
                upl += '<input type="hidden" name="fileurl[]" value="' + file.url + '">';
                upl += '<input type="hidden" name="file_id[]" value="' + file.file_id + '">';

                $(upl).appendTo('#uploadedform');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );

            /*
            if(progress == 100){
                $('#progress .bar').css('width','0%');
            }
            */
        }
    })
    .prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('select').select2({
      width : 'resolve'
    });


    $('#field_role').change(function(){
        //alert($('#field_role').val());
        // load default permission here
    });

    /*

    $('#ecoFriendly').summernote({
        height: 300px
    });

    var editor = new wysihtml5.Editor('ecoFriendly', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });
    */

    //$('#color_input').colorPicker();

    // dynamic tables

});

</script>

@stop