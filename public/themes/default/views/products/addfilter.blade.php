{{ Former::select('assigned', 'Show only product in category : ')
        ->options(Prefs::ExtractProductCategory() )
        ->id('assigned-product-filter');
}}&nbsp;&nbsp;
<a class="btn" id="refresh_filter">Refresh</a>
<a class="btn" id="assign-product">Assign Product to Category</a>
<a class="btn" id="assign-status">Set Status</a>

<div id="assign-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Assign Selected to</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::select('assigned', 'Category')->options(Prefs::getProductCategory()->ProductCatToSelection('slug','title',true))->id('assigned-category')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-assign">Assign</button>
  </div>
</div>

<div id="status-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalStatus" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalStatus">Assign Selected to</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::select('status', 'Status')->options(array('active'=>'Active','inactive'=>'Inactive'))->id('assigned-status')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-status">Assign</button>
  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#refresh_filter').on('click',function(){
            oTable.fnDraw();
        });

        $('#assigned-product-filter').on('change',function(){
            oTable.fnDraw();
        });

        $('#assign-product').on('click',function(e){
            $('#assign-modal').modal();
            e.preventDefault();
        });

        $('#assign-status').on('click',function(e){
            $('#status-modal').modal();
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
                $.post('{{ URL::to('ajax/assigncat')}}',
                    {
                        category : $('#assigned-category').val(),
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

        $('#do-status').on('click',function(){
            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            if(ids.length > 0){
                $.post('{{ URL::to('ajax/assignstatus')}}',
                    {
                        status : $('#assigned-status').val(),
                        product_ids : ids
                    },
                    function(data){
                        $('#status-modal').modal('hide');
                        oTable.fnDraw();
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#status-modal').modal('hide');
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