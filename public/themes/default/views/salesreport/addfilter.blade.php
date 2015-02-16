{{ Former::select('assigned', 'Show only product in category : ')
        ->options(Prefs::getOutlet()->OutletToSelection('name','name') )
        ->id('outlet-filter');
}}<br />
<a class="btn btn-info btn-sm" id="refresh_filter">Refresh</a>
<a class="btn btn-info btn-sm" id="print_barcodes"><i class="fa fa-print"></i> Print Selected Barcodes</a>
<a class="btn btn-info btn-sm" id="move_outlets">Move Selection's Outlets</a>

<div id="assign-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div id="changestatus-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Change Status</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::select('assigned', 'Outlet')->options(Prefs::getOutlet()->OutletToSelection('name','name',true))->id('assigned-category')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-change-status">Save</button>
  </div>
</div>

<div id="print-modal" class="modal fade large" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myPrintModalLabel">Print Selected Codes</span></h3>
    </div>
    <div class="modal-body" >
        <h6>Print Sales Detail</h6>

        <iframe id="label_frame" name="label_frame" width="100%" height="90%"
        marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"
        title="Dialog Title">Your browser does not suppr</iframe>

    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-print">Print</button>
    </div>
</div>

<div id="detail-modal" class="modal fade large" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myPrintModalLabel">Sales Detail</span></h3>
    </div>
    <div class="modal-body" >

        <iframe id="detail_frame" name="label_frame" width="100%" height="90%"
        marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"
        title="Dialog Title">Your browser does not suppr</iframe>

    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-change-status">Change Status</button>
    <button class="btn btn-primary" id="do-sales-print">Print</button>
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
            oTable.draw();
        });

        $('#outlet-filter').on('change',function(){
            oTable.draw();
        });

        $('#move_outlets').on('click',function(e){
            $('#assign-modal').modal();
            e.preventDefault();
        });

        $('#label_refresh').on('click',function(){

            var sessionname = $('#session_name').val();

            var col = $('#label_columns').val();
            var res = $('#label_res').val();
            var cell_width = $('#label_cell_width').val();
            var cell_height = $('#label_cell_height').val();
            var margin_right = $('#label_margin_right').val();
            var margin_bottom = $('#label_margin_bottom').val();
            var font_size = $('#font_size').val();
            var code_type = $('#code_type').val();
            var offset_left = $('#label_offset_left').val();
            var offset_top = $('#label_offset_top').val();
            var src = '{{ URL::to('inventory/printlabel')}}/' + sessionname + '/' + col + ':' + res + ':' + cell_width + ':' + cell_height + ':' + margin_right + ':' + margin_bottom + ':' + font_size + ':' + code_type + ':' + offset_left + ':' + offset_top;

            $('#label_frame').attr('src',src);

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
                            $('#session_name').val(data.sessionname);

                            var col = $('#label_columns').val();
                            var res = $('#label_res').val();
                            var cell_width = $('#label_cell_width').val();
                            var cell_height = $('#label_cell_height').val();
                            var margin_right = $('#label_margin_right').val();
                            var margin_bottom = $('#label_margin_bottom').val();
                            var font_size = $('#font_size').val();
                            var code_type = $('#code_type').val();
                            var offset_left = $('#label_offset_left').val();
                            var offset_top = $('#label_offset_top').val();
                            var src = '{{ URL::to('inventory/printlabel')}}/' + data.sessionname + '/' + col + ':' + res + ':' + cell_width + ':' + cell_height + ':' + margin_right + ':' + margin_bottom + ':' + font_size + ':' + code_type + ':' + offset_left + ':' + offset_top;
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

        $('#do-sales-print').click(function(){
            console.log('print');
            var pframe = document.getElementById('detail_frame');
            var pframeWindow = pframe.contentWindow;
            pframeWindow.print();

        });

        $('#label_default').on('click',function(){
            var col = $('#label_columns').val();
            var res = $('#label_res').val();
            var cell_width = $('#label_cell_width').val();
            var cell_height = $('#label_cell_height').val();
            var margin_right = $('#label_margin_right').val();
            var margin_bottom = $('#label_margin_bottom').val();
            var font_size = $('#font_size').val();
            var code_type = $('#code_type').val();
            var offset_left = $('#label_offset_left').val();
            var offset_top = $('#label_offset_top').val();

            $.post('{{ URL::to('ajax/printdefault')}}',
                {
                    col : col,
                    res : res,
                    cell_width : cell_width,
                    cell_height : cell_height,
                    margin_right : margin_right,
                    margin_bottom : margin_bottom,
                    font_size : font_size,
                    code_type : code_type,
                    offset_left : offset_left,
                    offset_top : offset_top
                },
                function(data){
                    if(data.result == 'OK'){
                        alert('Print parameters set as default');
                    }else{
                        alert('Print parameters failed to set default');
                    }
                }
                ,'json');
                e.preventDefault();

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