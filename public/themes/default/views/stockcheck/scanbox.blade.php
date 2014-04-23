<div class="form-horizontal">
    {{ Former::select('outlet')->options(Prefs::getOutlet()->OutletToSelection('id','name') )->id('scanoutlet') }} &nbsp;<span>select one of existing outlet before scanning</span><br /><br />
    {{ Former::text('barcode','')->id('barcode')->class('span6')->placeholder('Always make sure to put cursor in this box when scanning') }}

    <div id="scanResult">
        Hello !
    </div>
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
        var outlet_id = $('#scanoutlet').val();

        if(outlet_id == '' || txtin == ''){
            alert('Select outlet before scanning');
            $('#barcode').val('');
        }else{
            $.post('{{ URL::to('ajax/scancheck') }}',
                {
                    'txtin':txtin,
                    'outlet_id': outlet_id
                },
                function(data){
                    if(data.result == 'OK'){
                        oTable.fnDraw();
                    }
                    $('#scanResult').html(data.msg);
                },'json'
            );
        }

    }

    function clearList(){
        $('#barcode').val('').focus();
    }

});

</script>
