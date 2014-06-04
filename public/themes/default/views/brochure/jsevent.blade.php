            if ($(e.target).is('.active')) {
                var _id = e.target.id;
                var answer = confirm("Are you sure you want to ACTIVATE this item ? This will DEACTIVATE other templates");

                console.log(answer);

                if (answer == true){

                    $.post('{{ URL::to('brochure/activate') }}',{'id':_id}, function(data) {
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
