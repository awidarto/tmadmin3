<a href="" id="regenerate" class="btn btn-primary">Regenerate Report</a>
<script type="text/javascript">
    $(document).ready(function(){
        $('#regenerate').on('click',function(){
            $.get('{{ URL::to('tofin') }}',
                null,
                function(data){
                    if(data.result == 'OK:GENERATED'){
                        alert('Data regenerated');
                    }
                },
                'json');
            return false;
        });
    });

</script>