{{ Former::select('outlet')->options(Prefs::getOutlet()->OutletToSelection('id','name') )->id('scanoutlet') }}
{{ Former::text('barcode','')->id('barcode')->class('span10') }}

<div id="scanResult">
    Hello !
</div>


<script type="text/javascript">


$(document).ready(function() {

    $('#barcode').focus();

    $('#barcode').on('keyup',function(ev){
        if(ev.keyCode == '13'){
            onScanResult();
        }
        //$('#barcode').val($('#barcode').val() + event.keyCode);
    });

    function onScanResult(){
        var txtin = $('#barcode').val();

        $.post('{{ URL::to('ajax/scancheck') }}',
            {
                'txtin':txtin,
                'outlet_id': $('#scanoutlet').val()
            },
            function(data){
                if(data.result == 'OK'){
                    oTable.fnDraw();
                }
                $('#scanResult').html(data.msg);
            },'json'
        );
    }

    function clearList(){
        $('#barcode').val('').focus();
    }

});

</script>
