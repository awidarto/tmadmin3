            if ($(e.target).is('.active')) {
                var _id = e.target.id;
                var type = $(e.target).data('type');
                console.log(type);

                var answer = confirm("Are you sure you want to ACTIVATE this item ? This will DEACTIVATE other templates");


                if (answer == true){

                    $.post('{{ URL::to('templates/activate') }}',{'id':_id, 'type': type }, function(data) {
                        if(data.status == 'OK'){
                            //redraw table

                            oTable.fnStandingRedraw();
                            alert("Item id : " + _id + " activated");
                        }
                    },'json');

                }else{
                    alert("Activation cancelled");
                }
            }
