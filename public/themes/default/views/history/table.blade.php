@extends('layout.fixedstatic')

@section('left')
<dl>
    <dt>Asset Code</dt>
    <dd>{{ $a->SKU }}</dd>
    <dt>Status</dt>
    <dd>{{ $a->status }}</dd>
    <dt>Asset Type</dt>
    <dd>{{ $a->assetType }}</dd>
    <dt>Location</dt>
    <dd>{{ $a->locationId }}</dd>
    <dt>Rack</dt>
    <dd>{{ $a->rackId }}</dd>
    <dt>Description</dt>
    <dd>{{ $a->itemDescription }}</dd>
    <dt>IP</dt>
    <dd>{{ $a->IP }}</dd>
    <dt>Host Name</dt>
    <dd>{{ $a->hostName }}</dd>
    <dt>OS</dt>
    <dd>{{ $a->OS }}</dd>
    <dt>Power Status</dt>
    <dd>{{ ($a->powerStatus)?'Yes':'No' }}</dd>
    <dt>Label Status</dt>
    <dd>{{ ($a->labelStatus)?'Yes':'No' }}</dd>
    <dt>Virtual Status</dt>
    <dd>{{ ($a->virtualStatus)?'Yes':'No' }}</dd>

    <dt>Owner</dt>
    <dd>{{ $a->owner }}</dd>
    <dt>PIC</dt>
    <dd>{{ $a->PIC }}</dd>
    <dt>Contract Number</dt>
    <dd>{{ $a->contractNumber }}</dd>
    <dt>Tags</dt>
    <dd>{{ $a->tags }}</dd>

</dl>


@stop

@section('right')

{{ $table }}

@stop

@section('modals')

<div id="status-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalStatus" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalStatus">Approval</span></h5>
  </div>
  <div class="modal-body" >
        {{ Former::hidden('approvalId','')->id('approvalIdForm')}}
        {{ Former::select('approvalStatus', 'Approval Status')->options(array('pending'=>'Pending','verified'=>'Verified'))->id('approval-status')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-approve">Assign</button>
  </div>
</div>


@stop

@section('aux')
<script type="text/javascript">
    $(document).ready(function(){
        $('#refresh_filter').on('click',function(){
            oTable.draw();
        });

        $('.change-approval').on('click',function(e){
            console.log(this);

            $('#approvalIdForm').val( $(this).data('id') );

            $('#status-modal').modal();
            e.preventDefault();
        });

        $('#do-approve').on('click',function(){

            $.post('{{ URL::to('ajax/approval')}}',
                {
                    approval_status : $('#approval-status').val(),
                    ticket_id : $('#approvalIdForm').val()
                },
                function(data){
                    if(data.result == 'OK'){
                        var ticket_id = $('#approvalIdForm').val();
                        var approval_status = $('#approval-status').val();
                        if(approval_status == 'verified'){
                            var btn = $('.btn.' + ticket_id);
                            console.log(btn);

                            btn.removeClass('btn-info').addClass('btn-success').html(approval_status);
                        }
                        $('#status-modal').modal('hide');
                    }else{
                        alert('Ticket not found');
                        $('#status-modal').modal('hide');
                    }
                }
                ,'json');

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
                        oTable.draw();
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#status-modal').modal('hide');
            }

        });

    });
</script>
@stop