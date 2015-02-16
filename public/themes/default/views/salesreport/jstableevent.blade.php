            if ($(e.target).is('.viewdetail')) {
                var _id = e.target.id;

                console.log('id : ' + _id);

                var url = '{{ URL::to('salesreport/detail/')}}/' + _id;
                $('#detail_frame').attr('src',url);

                $('#detail-modal').modal('show');

            }
