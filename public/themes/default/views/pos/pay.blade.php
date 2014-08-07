<form id="pay-form">
    <div class="row-fluid form-vertical payform" >
        <div class="span3">
            <h3>Buyer Info</h3>
            {{ Former::text('name','Name')->id('name')->class('span12 left') }}
            {{ Former::select('gender','L/P')->id('gender')->class('span4')->options(array('L'=>'L','P'=>'P')) }}
            {{ Former::text('address','Address')->id('address')->class('span12 left') }}
        </div>
        <div class="span3">
            <h3>Credit Card</h3>
            {{ Former::text('cc_amount','Amount')->id('cc-amount')->class('span12 amounts') }}
            {{ Former::text('cc_number','Card Number')->id('cc-number')->class('span12') }}
            {{ Former::text('cc_expiry','Expiry Date')->id('cc-expiry')->class('span6')->help('MMYY') }}
        </div>
        <div class="span3">
            <h3>Debit Card</h3>
            {{ Former::text('dc_amount','Amount')->id('dc-amount')->class('span12 amounts') }}
            {{ Former::text('dc_number','Card Number')->id('dc-number')->class('span12') }}
        </div>
        <div class="span3">
            <h3>Cash</h3>
            {{ Former::text('payable_amount','Payable Amount')->id('payable-amount')->class('span12 amounts') }}
            {{ Former::text('cash_amount','Paid In Cash')->id('cash-amount')->class('span12') }}
            {{ Former::text('cash_change','Change')->id('cash-change')->class('span12')->disabled('true') }}
            {{--
            <button class="btn btn-medium btn-info pull-right" id="recalculate" >Recalculate</button>
            --}}
        </div>
    </div>
    <div class="row-fluid payform" style="border-top:thin solid #AAA;">
        <div class="span8 hidden-phone" style="text-align:right;">
            <h1>Total</h1>
        </div>
        <div class="span4 pull-right" style="text-align:right;">
            <h1 class="visible-phone pull-left" style="display:inline-block;" >Total</h1>
            <h2 id="payable-total">0</h2>
        </div>
    </div>
</form>

<style type="text/css">
.payform input[disabled="disabled"],
.payform input[disabled],
.payform input[disabled]:focus,
.payform input[disabled="disabled"]:focus{
    color:#000;
}

input.left{
    text-align: left;
}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        function notNan(v){
            if(v == '' || v == null || typeof v === "undefined" || isNaN(v) ){
                v = 0;
            }
            return parseInt(v);
        }

        function recalculate(){
            var total = parseInt($('#total_price_value').val());

            var cc = 0;
            var dc = 0;
            var paid_cash = 0;

            cc = parseInt( $('#cc-amount').val());
            dc = parseInt( $('#dc-amount').val());
            paid_cash = parseInt( $('#cash-amount').val());

            var cash_amount = notNan(total) - ( notNan(dc) + notNan(cc));

            $('#payable-amount').val( cash_amount );

            var change = notNan(paid_cash) - notNan(cash_amount);

            if(notNan(paid_cash) < notNan(cash_amount)){
                change = 0;
            }

            $('#cash-total').html( notNan(paid_cash) );
            $('#cash-change').val(notNan(change));
        }

        $('#recalculate').on('click',function(){
            recalculate();
        })

        $('#cash-amount').on('keyup',function(){
            recalculate();
        });

        $('#cc-amount').on('keyup',function(){
            recalculate();
        });

        $('#dc-amount').on('keyup',function(){
            recalculate();
        });

    });

</script>