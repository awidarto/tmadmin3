{{ Former::select('assigned', 'Show only product in category : ')
        ->options(Prefs::getOutlet()->OutletToSelection('name','name') )
        ->id('outlet-filter');
}}&nbsp;&nbsp;
<a class="btn" id="refresh_filter">Refresh</a><br />
<a class="btn" id="print_barcodes"><i class="icon-print"></i> Print Selected Barcodes</a>
<a class="btn" id="move_outlets">Move Selection's Outlets</a>

<div id="assign-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Move Selected to</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::select('assigned', 'Outlet')->options(Prefs::getOutlet()->OutletToSelection('name','name',true))->id('assigned-category')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-assign">Move</button>
  </div>
</div>

<div id="print-modal" class="modal hide fade large" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myPrintModalLabel">Print Selected Codes</span></h3>
    </div>
    <div class="modal-body" >
        <div style="border-bottom:thin solid #ccc;">
            Print options :
            <label>
                Number of columns
                <input type="text" value="2" id="label_columns" class="span1" />
                Resolution
                <input type="text" value="150" id="label_res"  class="span1" /> ppi
                Label height
                <input type="text" value="45" id="label_height" class="span1" /> px
                Gap between label
                <input type="text" value="20" id="label_gap" class="span1" /> px
                <button id="label_default">make default</button>
                <button id="label_refresh">refresh</button>
            </label>
        </div>
        <input type="hidden" value="" id="label_id" />
        <iframe id="label_frame" name="label_frame" width="100%" height="90%"
        marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"
        title="Dialog Title">Your browser does not suppr</iframe>

    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-assign">Print</button>
    </div>
</div>

<style type="text/css">

.modal.large {
    width: 80%; /* respsonsive width */
    margin-left:-40%; /* width/2) */
}

.modal.large .modal-body{
    max-height: 800px;
    height: 550px;
}

</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('#refresh_filter').on('click',function(){
            oTable.fnDraw();
        });

        $('#outlet_filter').on('change',function(){
            oTable.fnDraw();
        });

        $('#move_outlets').on('click',function(e){
            $('#assign-modal').modal();
            e.preventDefault();
        });

        $('#print_barcodes').on('click',function(){

            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            if(ids.length > 0){
                $.post('{{ URL::to('ajax/sessionsave')}}',
                    {
                        data_array : ids
                    },
                    function(data){
                        if(data.result == 'OK'){

                            var col = $('#label_columns').val();
                            var res = $('#label_res').val();
                            var gap = $('#label_gap').val();
                            var height = $('#label_height').val();
                            var src = '{{ URL::to('inventory/printlabel')}}/' + data.sessionname + '/' + col + '/' + res + '/' + gap + '/' + height;
                            $('#label_frame').attr('src',src);
                            $('#print-modal').modal('show');
                        }else{
                            $('#print-modal').modal('hide');
                        }
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#print-modal').modal('hide');
            }

        });

        $('#do-assign').on('click',function(){
            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            if(ids.length > 0){
                $.post('{{ URL::to('ajax/assignoutlet')}}',
                    {
                        outlet : $('#assigned-category').val(),
                        product_ids : ids
                    },
                    function(data){
                        $('#assign-modal').modal('hide');
                        oTable.fnDraw();
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#assign-modal').modal('hide');
            }

        });

        $('#unassign-prop').on('click',function(){
            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            var answer = confirm('Are you sure you want to un-assign these Properties ?');

            console.log(answer);

            if (answer == true){

                $.post('{{ URL::to('ajax/unassign')}}',
                {
                    user_id : $('#assigned-agent-filter').val(),
                    prop_ids : ids
                },
                function(data){
                    oTable.fnDraw();
                }
                ,'json');

            }else{
                alert("Unassignment cancelled");
            }

        });

    });
</script>