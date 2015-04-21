<form id="pay-form">
    <div class="row form-horizontal payform" >
        <div class="col-md-3">
            <h3>Buyer Info</h3>
            {{ Former::text('name','Name')->id('name')->class('form-control col-md-12 left') }}
            {{ Former::text('address','Address')->id('address')->class('form-control col-md-12 left') }}
            {{ Former::text('phone','Phone')->id('phone')->class('form-control col-md-12 left') }}
        </div>
        <div class="col-md-3">
            <h3>Credit Card</h3>
            {{ Former::text('cc_amount','Amount')->id('cc-amount')->class('form-control col-md-12 amounts') }}
            {{ Former::text('cc_number','Card Number')->id('cc-number')->class('form-control col-md-12') }}
            {{ Former::text('cc_expiry','Expiry Date')->id('cc-expiry')->class('form-control col-md-6')->help('MMYY') }}
        </div>
        <div class="col-md-3">
            <h3>Debit Card</h3>
            {{ Former::text('dc_amount','Amount')->id('dc-amount')->class('form-control col-md-12 amounts') }}
            {{ Former::text('dc_number','Card Number')->id('dc-number')->class('form-control col-md-12') }}
        </div>
        <div class="col-md-3">
            <h3>Cash</h3>
            {{ Former::text('payable_amount','Payable Amount')->id('payable-amount')->class('form-control col-md-12 amounts') }}
            {{ Former::text('cash_amount','Paid In Cash')->id('cash-amount')->class('form-control col-md-12') }}
            {{ Former::text('cash_change','Change')->id('cash-change')->class('form-control col-md-12')->disabled('true') }}
            {{--
            <button class="btn btn-medium btn-info pull-right" id="recalculate" >Recalculate</button>
            --}}
        </div>
    </div>
    <div class="row payform"   style="border-top:thin solid #AAA;margin-top:8px;">
        <div class="col-md-7 hidden-phone" style="text-align:right;">
            <h4>Total due</h4>
        </div>
        <div class="col-md-5 pull-right" style="text-align:right;">
            <h4 id="payable-total">0</h4>
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