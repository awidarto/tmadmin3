@extends('layout.fixedtwo')


@section('left')

        {{ Former::text('SKU','SKU') }}
        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}
        {{-- Former::select('category','Category')->options(Prefs::ExtractProductCategory()) --}}
        {{ Former::select('categoryLink','Category')->options(Prefs::getProductCategory()->productCatToSelection('slug', 'title' )) }}
        {{ Former::text('subCategory','Sub Category') }}

        {{ Former::text('series','Series') }}
        {{ Former::text('itemDescription','Description') }}
        {{ Former::text('itemGroup','Item Group')->help('for compound product only') }}

        <div class="row form-vertical">
            <div class="col-md-6">
                {{ Former::text('priceRegular','Regular Price')->class('form-control') }}
            </div>
            <div class="col-md-6">
                {{ Former::text('priceDiscount','Discount Price')->class('form-control') }}
            </div>
        </div>


        {{ Former::text('discFromDate','Disc. From')->class('form-control eventdate')
            ->id('fromDate')
            //->data_format('dd-mm-yyyy')
            ->append('<i class="fa fa-th"></i>') }}

        {{ Former::text('discToDate','Disc. Until')->class('form-control eventdate')
            ->id('toDate')
            //->data_format('dd-mm-yyyy')
            ->append('<i class="fa fa-th"></i>') }}

        {{ Former::text('material','Material') }}
        {{ Former::text('colour','Colour')->class('form-control col-md-4') }}
        {{--

        <div class="row form-vertical">
            <div class="col-md-4">
                {{ Former::text('colour','Colour')->class('form-control col-md-12') }}
            </div>
            <div class="col-md-4">
                {{ Former::text('colourHex','')->class('form-control pick-a-color') }}
            </div>
        </div>
        --}}

        <div class="row form-vertical">
            <div class="col-md-4">
                {{ Former::text('W','Width')->class('form-control')}}
            </div>
            <div class="col-md-4">
                {{ Former::text('H','Height')->class('form-control') }}
            </div>
            <div class="col-md-4">
                {{ Former::text('L','Length')->class('form-control') }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                {{ Former::text('Weight','Weight/Unit')->class('form-control')}}
            </div>
            <div class="col-md-4">
                {{ Former::text('D','Diameter')->class('form-control')}}
            </div>
            <div class="col-md-4">
                {{ Former::text('sizeDescription','Dimension Description') }}
            </div>
        </div>

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

        {{ Former::select('colorVariantParent','Show as Main Color Item')->options(array('yes'=>'Yes','no'=>'No')) }}

        {{ Former::text('colorVariant','Color Variant')->class('tag_color') }}

        {{ Former::text('relatedProducts','Related Products')->class('tag_related') }}

        {{ Former::text('recommendedProducts','Recommended Products')->class('tag_recommended') }}

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
        <h5>Inventory</h5>

        <table class="table " >
            <tr>
                <th>
                    Outlet
                </th>
                <th>
                    Initial Qty.
                </th>
            </tr>
            @foreach( Prefs::getOutlet()->OutletToArray() as $o)
                <tr>
                    <td>
                        {{ $o->name }}
                    </td>
                    <td>
                        <input type="hidden" name="outlets[]"  value="{{ $o->_id }}">
                        <input type="hidden" name="outletNames[]"  value="{{ $o->name }}">
                        <input type="text" class="col-md-6 form-control" id="{{ $o->_id }}" name="addQty[]" value="" />
                    </td>
                </tr>
            @endforeach
        </table>

        <h5>Pictures</h5>
        <?php
            $fupload = new Fupload();
        ?>
        {{ $fupload->id('imageupload')->title('Select Images')->label('Upload Images')->make() }}

@stop
@section('modals')

@stop

@section('aux')

{{ HTML::style('css/autocompletes.css') }}
{{ HTML::script('js/autocompletes.js') }}

<script type="text/javascript">

$(document).ready(function() {

    $('.pick-a-color').pickAColor({
        showHexInput:false
    });

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop