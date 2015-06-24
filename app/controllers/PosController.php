<?php

class PosController extends AdminController {

    public function __construct()
    {
        parent::__construct();

        $this->controller_name = str_replace('Controller', '', get_class());

        //$this->crumb = new Breadcrumb();
        //$this->crumb->append('Home','left',true);
        //$this->crumb->append(strtolower($this->controller_name));

        $this->model = new Transaction();
        //$this->model = DB::collection('documents');

    }

    public function getTest()
    {
        $raw = $this->model->where('docFormat','like','picture')->get();

        print $raw->toJSON();
    }


    public function getIndex()
    {

        $this->heads = array(
            //array('Photos',array('search'=>false,'sort'=>false)),
            array('Item',array('search'=>false,'sort'=>false)),
            array('Unit Id',array('search'=>false,'sort'=>false)),
            array('Qty',array('search'=>false,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Unit Price',array('search'=>false,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Total',array('search'=>false,'sort'=>false ,'attr'=>array('class'=>'')))
        );

        //print $this->model->where('docFormat','picture')->get()->toJSON();

        $open_session = Transaction::where('status','reserved')
                ->where('outletId','')
                ->distinct('sessionId')->get();

        $open_sessions = array();
        foreach ($open_session as $op) {
            $open_sessions[] = $op[0];
        }

        $add_data = array('open_sessions'=>$open_sessions);

        $this->additional_page_data = $add_data;

        $this->can_add = false;

        $this->place_action = 'none';

        $this->is_additional_action = true;

        $this->additional_action = View::make('pos.poscan')->with('additional_page_data',$this->additional_page_data)->render();

        $this->js_additional_param = "aoData.push( { 'name':'session', 'value': $('#current_session').val() }, { 'name':'tax', 'value': $('#tax_pct').val() }, { 'name':'disc_percentage', 'value': $('#disc_percentage').val() }, { 'name':'disc_nominal', 'value': $('#disc_nominal').val() }  );";

        $this->title = 'Point of Sales';

        $this->table_view = 'tables.pos';

        return parent::getIndex();

    }

    public function postIndex()
    {

        $this->fields = array(
            array('SKU',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'callback'=>'itemDesc')),
            array('unitId',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('quantity',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('unitPrice',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr' )),
            array('unitTotal',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr')),
        );

        $this->place_action = 'none';

        $this->def_order_by = 'SKU';

        $this->def_order_dir = 'desc';

        $session = Input::get('session');

        $session = (is_null($session) || !isset($session))?'':$session;

        $this->additional_query = array('sessionId'=>$session);

        return parent::postIndex();
    }

    public function tableResponder()
    {

        $fields = $this->fields;

        $count_all = 0;
        $count_display_all = 0;

        //print_r($fields);

        //array_unshift($fields, array('select',array('kind'=>false)));
        array_unshift($fields, array('seq',array('kind'=>false)));
        if($this->place_action == 'both' || $this->place_action == 'first'){
            array_unshift($fields, array('action',array('kind'=>false)));
        }

        $pagestart = Input::get('iDisplayStart');
        $pagelength = Input::get('iDisplayLength');

        $limit = array($pagelength, $pagestart);

        $defsort = 1;
        $defdir = -1;

        $idx = 0;
        $q = array();

        $hilite = array();
        $hilite_replace = array();

        for($i = 0;$i < count($fields);$i++){
            $idx = $i;

            //print_r($fields[$i]);

            $field = $fields[$i][0];
            $type = $fields[$i][1]['kind'];

            $qval = '';

            if(Input::get('sSearch_'.$i))
            {
                if( $type == 'text'){
                    if($fields[$i][1]['query'] == 'like'){
                        $pos = $fields[$i][1]['pos'];
                        if($pos == 'both'){
                            //$model->whereRegex($field,'/'.Input::get('sSearch_'.$idx).'/i');
                            //$this->model->where($field,'like','%'.Input::get('sSearch_'.$idx).'%');

                            $qval = new MongoRegex('/'.Input::get('sSearch_'.$idx).'/i');
                        }else if($pos == 'before'){
                            //$this->model->whereRegex($field,'/^'.Input::get('sSearch_'.$idx).'/i');
                            //$this->model->where($field,'like','%'.Input::get('sSearch_'.$idx));

                            $qval = new MongoRegex('/^'.Input::get('sSearch_'.$idx).'/i');
                        }else if($pos == 'after'){
                            //$this->model->whereRegex($field,'/'.Input::get('sSearch_'.$idx).'$/i');
                            //$this->model->where($field,'like', Input::get('sSearch_'.$idx).'%');

                            $qval = new MongoRegex('/'.Input::get('sSearch_'.$idx).'$/i');
                        }
                    }else{
                        $qval = Input::get('sSearch_'.$idx);

                        //$this->model->where($field,$qval);
                    }

                    $q[$field] = $qval;

                }elseif($type == 'numeric' || $type == 'currency'){
                    $str = Input::get('sSearch_'.$idx);

                    $sign = null;

                    $strval = trim(str_replace(array('<','>','='), '', $str));

                    $qval = (double)$strval;

                    /*
                    if(is_null($sign)){
                        $qval = new MongoInt32($strval);
                    }else{
                        $str = new MongoInt32($str);
                        $qval = array($sign=>$str);
                    }
                    */


                    if(strpos($str, "<=") !== false){
                        $sign = '$lte';

                        //$this->model->whereLte($field,$qval);
                        //$this->model->where($field,'<=',$qval);

                    }elseif(strpos($str, ">=") !== false){
                        $sign = '$gte';

                        //$this->model->whereGte($field,$qval);
                        //$this->model->where($field,'>=',$qval);

                    }elseif(strpos($str, ">") !== false){
                        $sign = '$gt';

                        //$this->model->whereGt($field,$qval);
                        //$this->model->where($field,'>',$qval);

                    }elseif(stripos($str, "<") !== false){
                        $sign = '$lt';

                        //$this->model->whereLt($field,$qval);
                        //$this->model->where($field,'<',$qval);

                    }

                    //print $sign;
                    if(!is_null($sign)){
                        $qval = array($sign=>$qval);
                    }

                    $q[$field] = $qval;

                }elseif($type == 'date'|| $type == 'datetime'){
                    $datestring = Input::get('sSearch_'.$idx);
                    $datestring = date('d-m-Y', $datestring / 1000);

                    if (($timestamp = $datestring) === false) {
                    } else {
                        $daystart = new MongoDate(strtotime($datestring.' 00:00:00'));
                        $dayend = new MongoDate(strtotime($datestring.' 23:59:59'));

                        $qval = array($field =>array('$gte'=>$daystart,'$lte'=>$dayend));
                        //echo "$str == " . date('l dS \o\f F Y h:i:s A', $timestamp);

                        //$this->model->whereBetween($field,$daystart,$dayend);

                    }
                    $qval = array('$gte'=>$daystart,'$lte'=>$dayend);
                    //$qval = Input::get('sSearch_'.$idx);

                    $q[$field] = $qval;

                }elseif($type == '__datetime'){
                    $datestring = Input::get('sSearch_'.$idx);

                    print $datestring;

                    $qval = new MongoDate(strtotime($datestring));

                    //$this->model->where($field,$qval);
                    $q[$field] = $qval;

                }


            }

        }

        if($this->additional_query){
            $q = array_merge( $q, $this->additional_query );
        }

        //print_r($q);


        /* first column is always sequence number, so must be omitted */

        $fidx = Input::get('iSortCol_0') - 1;

        $fidx = ($fidx == -1 )?0:$fidx;

        if(Input::get('iSortCol_0') == 0){
            $sort_col = $this->def_order_by;

            $sort_dir = $this->def_order_dir;
        }else{
            $sort_col = $fields[$fidx][0];

            $sort_dir = Input::get('sSortDir_0');

        }


        /*
        if(count($q) > 0){
            $results = $model->skip( $pagestart )->take( $pagelength )->orderBy($sort_col, $sort_dir )->get();
            $count_display_all = $model->count();
        }else{
            $results = $model->find(array(),array(),array($sort_col=>$sort_dir),$limit);
            $count_display_all = $model->count();
        }
        */

        //$model->where('docFormat','picture');

        $count_all = $this->model->count();
        $count_display_all = $this->model->count();

        if(is_array($q) && count($q) > 0){
            $results = $this->model->whereRaw($q)->skip( $pagestart )->take( $pagelength )->orderBy($sort_col, $sort_dir )->get();

            $count_display_all = $this->model->whereRaw($q)->count();

        }else{
            $results = $this->model->skip( $pagestart )->take( $pagelength )->orderBy($sort_col, $sort_dir )->get();

            $count_display_all = $this->model->count();

        }

        //print_r($results->toArray());

        $aadata = array();

        $form = $this->form;

        $counter = 1 + $pagestart;

        //grouping
        $artemp = array();

        foreach($results as $doc){
            if(in_array($doc->SKU, array_keys($artemp) )){
                $tdoc = $artemp[$doc->SKU];
                $tdoc->quantity = $tdoc->quantity + $doc->quantity;
                $tdoc->unitTotal = $tdoc->unitTotal + $doc->unitTotal;
                $tdoc->unitId = $tdoc->unitId.'<br />'.$this->shortunit( array('unitId'=>$doc->unitId) ).'<i class="fa fa-times-circle del_unit" id="'.$doc->unitId.'" ></i>';
                $artemp[$doc->SKU] = $tdoc;
            }else{
                $doc->quantity = 1;
                $doc->unitTotal = $doc->productDetail['priceRegular'];
                $doc->unitId = $this->shortunit( array('unitId'=>$doc->unitId) ).' <i class="fa fa-times-circle del_unit" id="'.$doc->unitId.'" ></i>';
                $artemp[$doc->SKU] = $doc;
            }
        }

        $results = array_values( $artemp );

        $count_all = count($results);
        $count_display_all = count($results);

        //print_r($results);
        $total_price = 0;

        foreach ($results as $doc) {

            $extra = $doc;
            $total_price = $total_price + $doc['unitTotal'];
            //$select = Former::checkbox('sel_'.$doc['_id'])->check(false)->id($doc['_id'])->class('selector');
            $actionMaker = $this->makeActions;

            $actions = $this->$actionMaker($doc);

            $row = array();

            $row[] = $counter;

            //$sel = Former::checkbox('sel_'.$doc['_id'])->check(false)->label(false)->id($doc['_id'])->class('selector')->__toString();
            $sel = '<input type="checkbox" name="sel_'.$doc['_id'].'" id="'.$doc['_id'].'" value="'.$doc['_id'].'" class="selector" />';
            $row[] = $sel;

            if($this->place_action == 'both' || $this->place_action == 'first'){
                $row[] = $actions;
            }


            foreach($fields as $field){
                if($field[1]['kind'] != false && $field[1]['show'] == true){

                    $fieldarray = explode('.',$field[0]);
                    if(is_array($fieldarray) && count($fieldarray) > 1){
                        $fieldarray = implode('\'][\'',$fieldarray);
                        $cstring = '$label = (isset($doc[\''.$fieldarray.'\']))?true:false;';
                        eval($cstring);
                    }else{
                        $label = (isset($doc[$field[0]]))?true:false;
                    }


                    if($label){

                        if( isset($field[1]['callback']) && $field[1]['callback'] != ''){
                            $callback = $field[1]['callback'];
                            $row[] = $this->$callback($doc, $field[0]);
                        }else{
                            if($field[1]['kind'] == 'datetime'){
                                if($doc[$field[0]] instanceof MongoDate){
                                    $rowitem = date('d-m-Y H:i:s',$doc[$field[0]]->sec);
                                }elseif ($doc[$field[0]] instanceof Date) {
                                    $rowitem = date('d-m-Y H:i:s',$doc[$field[0]]);
                                }else{
                                    //$rowitem = $doc[$field[0]];
                                    if(is_array($doc[$field[0]])){
                                        $rowitem = date('d-m-Y H:i:s', time() );
                                    }else{
                                        $rowitem = date('d-m-Y H:i:s',strtotime($doc[$field[0]]) );
                                    }
                                }
                            }elseif($field[1]['kind'] == 'date'){
                                if($doc[$field[0]] instanceof MongoDate){
                                    $rowitem = date('d-m-Y',$doc[$field[0]]->sec);
                                }elseif ($doc[$field[0]] instanceof Date) {
                                    $rowitem = date('d-m-Y',$doc[$field[0]]);
                                }else{
                                    //$rowitem = $doc[$field[0]];
                                    $rowitem = date('d-m-Y',strtotime($doc[$field[0]]) );
                                }
                            }elseif($field[1]['kind'] == 'currency'){
                                $num = (double) $doc[$field[0]];
                                $rowitem = number_format($num,2,',','.');
                            }else{
                                $rowitem = $doc[$field[0]];
                            }

                            if(isset($field[1]['attr'])){
                                $attr = '';
                                foreach ($field[1]['attr'] as $key => $value) {
                                    $attr .= $key.'="'.$value.'" ';
                                }
                                $row[] = '<span '.$attr.' >'.$rowitem.'</span>';
                            }else{
                                $row[] = $rowitem;
                            }

                        }

                        $row['extra'] = $extra;

                    }else{
                        $row[] = '';
                    }
                }
            }

            if($this->place_action == 'both'){
                $row[] = $actions;
            }


            $aadata[] = $row;

            $counter++;
        }

        $disc_pct = Input::get('disc_percentage');

        if($disc_pct == 0 || is_null($disc_pct) || $disc_pct == ''){
            $disc_pct = '';
            $disc_nominal = 0;
            $total_disc = 0;
            $total_disc_price = $total_price;
        }else{
            $total_disc = $total_price * ( $disc_pct / 100);
            $total_disc_price = $total_price - $total_disc;
        }


        $tax = Input::get('tax');

        if($tax == 0 || is_null($tax) || $tax == ''){
            $tax = 0;
            $total_tax = 0;
            $grand_total = $total_disc_price + $total_tax;
        }else{
            $total_tax = $total_disc_price * ( $tax / 100);
            $grand_total = $total_disc_price + $total_tax;
        }



        $taxform = '<div style="display:block;text-align:right">
                        <div class="input-group" style="margin-top:8px;text-align:right;">
                            <select id="tax_pct" class="form-control">
                                <option value="0" '.$this->taxSelect($tax, 0).' >No Tax</option>
                                <option value="10" '.$this->taxSelect($tax,10).' >PPn 10%</option>
                            </select>
                            <input type="hidden" id="total_tax_value" value="'.$total_tax.'">
                        </div>
                    </div>';

        $disc_pct_form = '<div style="display:block;text-align:right">
                        <div class="input-group" style="text-align:right;padding-top:8px;">
                            <input type="text" class="form-control" id="disc_percentage" value="'.$disc_pct.'" placeholder="%" />
                        </div>
                    </div>';

        $disc_nominal_form = '<div style="display:block;text-align:right">
                        <div class="input-group" style="text-align:right;padding-top:8px;">
                            <input type="text" class="form-control" id="disc_nominal" value="'.$total_disc.'" />
                        </div>
                    </div>';

        //print $taxform;

        $aadata[] = array('','','','','<h5 style="text-align:right;">Subtotal</h5>','<h5 style="text-align:right;">IDR</h5>','<h5 style="text-align:right;">'.Ks::idr($total_price).'</h5><input type="hidden" id="subtotal_price_value" value="'.$total_price.'">');
        //$aadata[] = array('','Discount',Former::text('')->id('disc_pct')->class('form-control col-md-3 total_disc_pct')->placeholder('%')->render(),'','<h5 style="text-align:right;">Total Discount</h5>','<h5 style="text-align:right;">IDR</h5>','<h5 style="text-align:right;">'.Ks::idr($total_price).'</h5><input type="hidden" id="subtotal_price_value" value="'.$total_price.'">');
        //$aadata[] = array('','','','<h5 style="text-align:right;">Tax</h5>',Former::text('')->id('tax_pct')->value(10)->class('form-control col-md-2 tax_pct')->placeholder('%')->render(),'<h5 style="text-align:right;">IDR</h5>','<h5 style="text-align:right;">'.Ks::idr($total_tax).'</h5><input type="hidden" id="total_tax_value" value="'.$total_tax.'">');

        //$aadata[] = array('','','','<h5>Disc.</h5>',$disc_pct_form,'<h5 style="text-align:right;">IDR</h5>',$disc_nominal_form);
        $aadata[] = array('','','','<h5>Disc.</h5>',$disc_pct_form,'<h5 style="text-align:right;">IDR</h5>','<h5 style="text-align:right;">'.Ks::idr($total_disc).'</h5><input type="hidden" id="disc_nominal" value="'.$total_disc.'" >');

        $aadata[] = array('','','','',$taxform,'<h5 style="text-align:right;">IDR</h5>','<h5 style="text-align:right;">'.Ks::idr($total_tax).'</h5><input type="hidden" id="tax_value" value="'.$total_tax.'" >');
        $aadata[] = array('','','','','<h4 style="text-align:right;">Total</h4>','<h4 style="text-align:right;">IDR</h4>','<h4 style="text-align:right;">'.Ks::idr($grand_total).'</h4><input type="hidden" id="total_price_value" value="'.$grand_total.'">');

        $sEcho = (int) Input::get('sEcho');

        $result = array(
            'sEcho'=>  $sEcho,
            'iTotalRecords'=>$count_all,
            'iTotalDisplayRecords'=> (is_null($count_display_all))?0:$count_display_all,
            'aaData'=>$aadata,
            'qrs'=>$q,
            'sort'=>array($sort_col=>$sort_dir)
        );

        return Response::json($result);
    }

    public function taxSelect($tax, $val){
        if($tax == $val){
            return 'selected';
        }else{
            return '';
        }
    }

    public function getSku()
    {
        $q = Input::get('term');
        $outlet = Input::get('outlet');

        $qsearch = new MongoRegex('/'.$q.'/i');

        $res = Stockunit::where('_id','regex',$qsearch)
                    ->where('status','available')
                    ->where('outletId',$outlet)->get()->toArray();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id'],'value'=>$r['_id'],'name'=>$r['_id'],'label'=>$r['_id'].' : '.$r['productDetail']['itemDescription'].' )');
        }

        return Response::json($result);
    }

    public function getPrint($id){
        //$sales = Sales::find($id)->toArray();

        $sales = Sales::where('sessionId',$id)->first()->toArray();

        //print_r($sales);

        //exit();

        $head = array(array('value'=>'Buyer Detail','attr'=>'colspan="2"'));
        $btab = array();
        $btab[] = array('Name',(isset($sales['buyer_name']))?$sales['buyer_name']:'');
        $btab[] = array('Address',(isset($sales['buyer_address']) )?$sales['buyer_address']:'');
        $btab[] = array('City',(isset($sales['buyer_city']))?$sales['buyer_city']:'');

        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($btab, $attr, $head);
        $tablebuyer = $t->build();


        $head = array(array('value'=>'Purchase Detail','attr'=>'colspan="2"'));
        $btab = array();
        $btab[] = array(
            array('value'=>'<h3>Total</h3>','attr'=>''),
            array('value'=>'<h3>IDR '.Ks::idr($sales['payable_amount']).'</h3>','attr'=>'')
        );

        if(isset($sales['transactionstatus'])){
            $transactionstatus = '<a href="#" id="transactionstatus" data-type="select" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >'.$sales['transactionstatus'].'</a>';
        }else{
            $transactionstatus = '<a href="#" id="transactionstatus" data-type="select" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >n/a</a>';
        }
        /*
        $btab[] = array('Current Status',$transactionstatus);
        $btab[] = array('Outlet',$sales['outletName']);
        $btab[] = array('Transaction Type',(isset($sales['transactiontype']))?$sales['transactiontype']:'' );
        */
        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($btab, $attr, $head);
        $tablepurchase = $t->build();

        if(isset($sales['shipment']['delivery_status'])){
            $delivery_status = '<a href="#" id="delivery_status" data-type="select" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >'.$sales['shipment']['delivery_status'].'</a>';
        }else{
            $delivery_status = '<a href="#" id="delivery_status" data-type="select" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >Pending</a>';
        }

        if(isset($sales['shipment']['delivery_number'])){
            $delivery_number = '<a href="#" id="delivery_number" data-type="text" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >'.$sales['shipment']['delivery_number'].'</a>';
        }else{
            $delivery_number = '<a href="#" id="delivery_number" data-type="text" data-pk="'.$sales['_id'].'" data-url="'.URL::to('ajax/salesedit').'" data-title="Delivery Status" >n/a</a>';
        }

        $head = array(array('value'=>'Shipment Detail','attr'=>'colspan="2"'));
        $btab = array();
        $btab[] = array('Shipped Via',(isset($sales['payment']['delivery_method']))?$sales['payment']['delivery_method']:'');
        $btab[] = array('Shipment Number',$delivery_number);
        $btab[] = array('Shipment Status',$delivery_status );

        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($btab, $attr, $head);
        $tableshipment = $t->build();


        $tabletrans = $this->trxDetail($sales['sessionId']);

        return View::make('print.purchasedetail')
                ->with('sales',$sales)
                ->with('tablebuyer',$tablebuyer)
                ->with('tablepurchase',$tablepurchase)
                ->with('tableshipment',$tableshipment)
                ->with('tabletrans',$tabletrans);
    }


    public function getPrinto($session_id)
    {
        $trx = Transaction::where('sessionId',$session_id)->get()->toArray();
        $pay = Payment::where('sessionId',$session_id)->first()->toArray();

        $tab = array();
        foreach($trx as $t){

            $tab[ $t['SKU'] ]['description'] = $t['productDetail']['itemDescription'];
            $tab[ $t['SKU'] ]['qty'] = ( isset($tab[ $t['SKU'] ]['qty']) )? $tab[ $t['SKU'] ]['qty'] + 1:1;
            $tab[ $t['SKU'] ]['tagprice'] = $t['productDetail']['priceRegular'];
            $tab[ $t['SKU'] ]['total'] = ( isset($tab[ $t['SKU'] ]['total']) )? $tab[ $t['SKU'] ]['total'] + $t['productDetail']['priceRegular']:$t['productDetail']['priceRegular'];

        }

        $tab_data = array();
        $gt = 0;
        foreach($tab as $k=>$v){
            $tab_data[] = array(
                    array('value'=>$v['description'], 'attr'=>'class="left"'),
                    array('value'=>$v['qty'], 'attr'=>'class="center"'),
                    array('value'=>Ks::idr($v['tagprice']), 'attr'=>'class="right"'),
                    array('value'=>Ks::idr($v['total']), 'attr'=>'class="right"'),
                );
            $gt += $v['tagprice'];
        }

        $tab_data[] = array('','','',array('value'=>Ks::idr($gt), 'attr'=>'class="right"'));

        $header = array(
            'things to buy',
            'unit',
            'tagprice',
            array('value'=>'price to pay', 'attr'=>'style="text-align:right"')
            );

        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($tab_data, $attr, $header);
        $tr_tab = $t->build();

        $viewmodel = Template::where('type','invoice')->where('status','active')->first();
        return View::make('print.invoice')
                        ->with('transtab', $tr_tab)
                        ->with('trx', $trx)
                        ->with('pay',$pay);
        /*
        return DbView::make($viewmodel)
                        ->field('body')
                        ->with('transtab', $tr_tab)
                        ->with('trx', $trx)
                        ->with('pay',$pay);
                        */
    }

    public function postCancel()
    {
        $in = Input::get();

        $trx = Transaction::where('sessionId', $in['sessionId'])->update(array('sessionStatus'=>'void', 'lastUpdate'=>new MongoDate() ));
        $pay = Payment::where('sessionId', $in['sessionId'])->update(array('sessionStatus'=>'void', 'lastUpdate'=>new MongoDate() ));


        $checktrx = Transaction::where('sessionId', $in['sessionId'])->where('sessionStatus','!=','void')->get()->toArray();
        $checkpay = Payment::where('sessionId', $in['sessionId'])->where('sessionStatus','!=','void')->get()->toArray();

        if( empty($checktrx) && empty($checkpay) ){
            return Response::json(array('result'=>'OK'));
        }else{
            return Response::json(array('result'=>'NOK'));
        }

        return Response::json(array('result'=>'OK'));
    }

    public function postSave()
    {
        $in = Input::get();
        //print_r($in);
            /*
            current_trx:3IseB
            cc_amount:
            cc_number:
            cc_expiry:
            dc_amount:
            dc_number:
            payable_amount:632500
            cash_amount:
            cash_change:
            */
            $trx = Payment::where('sessionId', $in['current_trx'])->first();

        //print_r($trx);

            if($trx){

            }else{
                $trx = new Payment();
                $trx->sessionId = $in['current_trx'];
                $trx->createdDate = new MongoDate();
                $trx->sessionStatus = 'open';
            }

            if($in['status'] == 'final'){
                $trx->sessionStatus = 'final';
            }

            $trx->by_name = $in['by_name'];
            $trx->by_address = $in['by_address'];
            $trx->cc_amount = $in['cc_amount'];
            $trx->cc_number = $in['cc_number'];
            $trx->cc_expiry = $in['cc_expiry'];
            $trx->dc_amount = $in['dc_amount'];
            $trx->dc_number = $in['dc_number'];
            $trx->payable_amount = $in['payable_amount'];
            $trx->cash_amount = $in['cash_amount'];
            $trx->cash_change = $in['cash_change'];
            $trx->tax_value = $in['tax_value'];
            $trx->tax_pct = $in['tax_pct'];
            $trx->disc_nominal = $in['disc_nominal'];
            $trx->disc_pct = $in['disc_pct'];
            $trx->lastUpdate = new MongoDate();

            if(isset($trx->invoice_number) && $trx->invoice_number != '' ){

            }else{
                $prefix = 'TM-'.date('Y',time());
                $infix = date('m',time());
                $invnum = Prefs::GetInvoiceSequence($prefix, 5, $infix);
                $trx->invoice_number = $invnum;
            }

            $payment = $trx->toArray();

            $trx->save();


            //if($in['status'] == 'final'){

                $itarray = array();
                $unitarr = array();

                $items = Transaction::where('sessionId',$in['current_trx'])->get();
                $outlet_id = '';
                $outlet_name = '';
                foreach($items as $item){
                    //print_r($item->toArray());
                    $outletId = $item->outletId;
                    $outletName = $item->outletName;

                    $item->sessionStatus = 'final';

                    $unit = Stockunit::find($item->unitId);
                    //print_r($unit);
                    if($unit){
                        $unit->status = 'sold';
                        $unit->lastUpdate = new MongoDate();
                        $itarray[] = $item->toArray();
                        $unitarr[] = $unit->toArray();

                        $unit->save();
                        $item->save();
                    }

                }

                $sales = Sales::where('sessionId', $in['current_trx'])->first();

                if($sales){

                }else{
                    $sales = new Sales();
                    $sales->sessionId = $in['current_trx'];
                    $sales->createdDate = new MongoDate();
                }
                $sales->outletId = $outletId;
                $sales->outletName = $outletName;

                $sales->buyer_name = $in['by_name'];
                $sales->buyer_address = $in['by_address'];
                $sales->cc_amount = $in['cc_amount'];
                $sales->cc_number = $in['cc_number'];
                $sales->cc_expiry = $in['cc_expiry'];
                $sales->dc_amount = $in['dc_amount'];
                $sales->dc_number = $in['dc_number'];
                $sales->payable_amount = $in['payable_amount'];
                $sales->cash_amount = $in['cash_amount'];
                $sales->cash_change = $in['cash_change'];
                $sales->disc_nominal = $in['disc_nominal'];
                $sales->disc_pct = $in['disc_pct'];
                $sales->tax_value = $in['tax_value'];
                $sales->tax_pct = $in['tax_pct'];

                $sales->transaction = $itarray;
                $sales->stockunit = $unitarr;
                $sales->payment = $payment;
                $sales->transactiontype = 'pos';
                $sales->lastUpdate = new MongoDate();
                $sales->save();
            //}

            return Response::json(array( 'result'=>'OK', 'status'=>$in['status'] ));

    }

    public function postDelunit()
    {
        $id = Input::get('id');

        $controller_name = strtolower($this->controller_name);

        $model = $this->model;

        if(is_null($id)){
            $result = array('status'=>'ERR','data'=>'NOID');
        }else{

            Stockunit::where('_id', $id)->update(array('status'=>'available'));

            $stat = Stockunit::where('_id', $id)->first();

            if( isset($stat) && isset($stat->status) && $stat->status == 'available'){

                if($model->where('unitId',$id)->delete()){
                    Event::fire($controller_name.'.delete_unit',array('id'=>$id,'result'=>'OK'));
                    $result = array('status'=>'OK','data'=>'UNITDELETED');
                }else{
                    Event::fire($controller_name.'.delete_unit',array('id'=>$id,'result'=>'FAILED'));
                    $result = array('status'=>'ERR','data'=>'DELETEFAILED');
                }
            }else{
                Event::fire($controller_name.'.delete_unit',array('id'=>$id,'result'=>'FAILED'));
                $result = array('status'=>'ERR','data'=>'DELETEFAILED');
            }


        }

        return Response::json($result);

    }

    public function postScan()
    {
        $in = Input::get();

        $code = $in['txtin'];
        $outlet_id = $in['outlet_id'];
        $use_outlet = $in['search_outlet'];
        $action = strtolower( $in['action'] );
        $session = $in['session'];

        $outlets = Prefs::getOutlet()->OutletToSelection('_id', 'name', false);

        $outlet_name = $outlets[$outlet_id];

        $res = 'OK';
        $msg = '';

        if(strripos($code, '|') >= 0){
            $rcode = explode('|', $code);
            if(count($rcode) > 1){
                $SKU = $rcode[0];
                $unit_id = $rcode[1];
            }else{
                $SKU = trim($code);
                $unit_id = null;
            }
        }else{
            $SKU = trim($code);
            $unit_id = null;
        }

        switch($action){
            case 'add':
                if(is_null($unit_id)){
                    $res = 'NOK';
                    $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                    break;
                }
                $u = Stockunit::where('SKU','=', $SKU)
                    ->where('_id', 'like', '%'.$unit_id )
                    ->where('status','available')
                    ->first();

                if($u){

                    $ul = $u->toArray();

                    $ul['scancheckDate'] = new MongoDate();
                    $ul['createdDate'] = new MongoDate();
                    $ul['lastUpdate'] = new MongoDate();
                    $ul['action'] = $action;
                    $ul['status'] = 'reserved';
                    $ul['quantity'] = 1;
                    $ul['unitPrice'] = $ul['productDetail']['priceRegular'];
                    $ul['unitTotal'] = $ul['productDetail']['priceRegular'];
                    $ul['deliverTo'] = $outlet_name;
                    $ul['deliverToId'] = $outlet_id;
                    $ul['returnTo'] = $outlet_name;
                    $ul['returnToId'] = $outlet_id;

                    $ul['sessionId'] = $session;
                    $ul['sessionStatus'] = 'open';

                    $unit_id = $ul['_id'];

                    unset($ul['_id']);

                    $ul['unitId'] = $unit_id;

                    Transaction::insert($ul);

                    $history = array(
                        'datetime'=>new MongoDate(),
                        'action'=>'pos',
                        'price'=>$ul['productDetail']['priceRegular'],
                        'status'=>$ul['status'],
                        'outletName'=>$ul['outletName']
                    );

                    //change status to sold
                    $u->status = 'reserved';
                    $u->push('history', $history);

                    $u->save();

                    $res = 'OK';

                    $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                }else{
                    $res = 'NOK';
                    $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                }

                break;
            case 'remove':
                    if(is_null($unit_id)){
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: NOT FOUND';
                        break;
                    }

                    $u = Stockunit::where('SKU','=', $SKU)
                        ->where('_id', 'like', '%'.$unit_id )
                        ->first();

                    if($u){

                        $ul = $u->toArray();

                        $ul['scancheckDate'] = new MongoDate();
                        $ul['createdDate'] = new MongoDate();
                        $ul['lastUpdate'] = new MongoDate();
                        $ul['action'] = $action;
                        $ul['deliverTo'] = $outlet_name;
                        $ul['deliverToId'] = $outlet_id;
                        $ul['returnTo'] = $outlet_name;
                        $ul['returnToId'] = $outlet_id;

                        $unit_id = $ul['_id'];

                        unset($ul['_id']);

                        $ul['unitId'] = $unit_id;

                        Stockunitlog::insert($ul);

                        $history = array(
                            'datetime'=>new MongoDate(),
                            'action'=>$action,
                            'price'=>$ul['productDetail']['priceRegular'],
                            'status'=>$ul['status'],
                            'outletName'=>$ul['outletName']
                        );

                        $u->push('history', $history);

                        $u->save();

                        $res = 'OK';
                        $msg = 'SKU: '.$ul['SKU'].' <br />Unit ID: '.$unit_id.' <br />Outlet: '.$ul['outletName'];

                    }else{
                        $res = 'NOK';
                        $msg = 'SKU: '.$SKU.' <br />Unit ID: '.$unit_id.' <br />NOT FOUND in this outlet';
                    }

                break;
            default:
                break;
        }

        $total_price = Transaction::where('sessionId',$session)
                        ->sum('unitPrice');

        $result = array(
            'total_price'=>$total_price,
            'result'=>$res,
            'msg'=>$msg
        );

        return Response::json($result);
    }

    public function postOpensession()
    {
        $outlet = Input::get('outlet_id');

        $open_session = Transaction::where('outletId',$outlet)
                            ->where('sessionStatus','open')
                            ->distinct('sessionId')->get()->toArray();

        $open_sessions = array();
        foreach ($open_session as $op) {
            $open_sessions[] = $op[0];
        }

        $result = array(
            'opensession'=>$open_sessions,
            'result'=>'OK'
        );

        return Response::json($result);

    }

    public function itemDesc($data)
    {
        return $data['SKU'].'<br />'.$data['productDetail']['itemDescription'];
    }

    public function unitPrice($data)
    {
        return Ks::idr($data['productDetail']['priceRegular']);
    }

    public function beforeSave($data)
    {
        $defaults = array();

        $files = array();

        if( isset($data['file_id']) && count($data['file_id'])){

            $data['defaultpic'] = (isset($data['defaultpic']))?$data['defaultpic']:$data['file_id'][0];
            $data['brchead'] = (isset($data['brchead']))?$data['brchead']:$data['file_id'][0];
            $data['brc1'] = (isset($data['brc1']))?$data['brc1']:$data['file_id'][0];
            $data['brc2'] = (isset($data['brc2']))?$data['brc2']:$data['file_id'][0];
            $data['brc3'] = (isset($data['brc3']))?$data['brc3']:$data['file_id'][0];

            for($i = 0 ; $i < count($data['thumbnail_url']);$i++ ){

                if($data['defaultpic'] == $data['file_id'][$i]){
                    $defaults['thumbnail_url'] = $data['thumbnail_url'][$i];
                    $defaults['large_url'] = $data['large_url'][$i];
                    $defaults['medium_url'] = $data['medium_url'][$i];
                    $defaults['full_url'] = $data['full_url'][$i];
                }

                $files[$data['file_id'][$i]]['thumbnail_url'] = $data['thumbnail_url'][$i];
                $files[$data['file_id'][$i]]['large_url'] = $data['large_url'][$i];
                $files[$data['file_id'][$i]]['medium_url'] = $data['medium_url'][$i];
                $files[$data['file_id'][$i]]['full_url'] = $data['full_url'][$i];

                $files[$data['file_id'][$i]]['delete_type'] = $data['delete_type'][$i];
                $files[$data['file_id'][$i]]['delete_url'] = $data['delete_url'][$i];
                $files[$data['file_id'][$i]]['filename'] = $data['filename'][$i];
                $files[$data['file_id'][$i]]['filesize'] = $data['filesize'][$i];
                $files[$data['file_id'][$i]]['temp_dir'] = $data['temp_dir'][$i];
                $files[$data['file_id'][$i]]['filetype'] = $data['filetype'][$i];
                $files[$data['file_id'][$i]]['fileurl'] = $data['fileurl'][$i];
                $files[$data['file_id'][$i]]['file_id'] = $data['file_id'][$i];
                $files[$data['file_id'][$i]]['caption'] = $data['caption'][$i];
            }
        }else{
            $data['thumbnail_url'] = array();
            $data['large_url'] = array();
            $data['medium_url'] = array();
            $data['full_url'] = array();
            $data['delete_type'] = array();
            $data['delete_url'] = array();
            $data['filename'] = array();
            $data['filesize'] = array();
            $data['temp_dir'] = array();
            $data['filetype'] = array();
            $data['fileurl'] = array();
            $data['file_id'] = array();
            $data['caption'] = array();

            $data['defaultpic'] = '';
        }

        $data['defaultpictures'] = $defaults;
        $data['productDetail']['files'] = $files;

        return $data;
    }

    public function beforeUpdate($id,$data)
    {
        $defaults = array();

        $unitdata = array_merge(array('id'=>$id),$data);

        $this->updateStock($unitdata);

        unset($data['outlets']);
        unset($data['outletNames']);
        unset($data['addQty']);
        unset($data['adjustQty']);

        $files = array();

        if( isset($data['file_id']) && count($data['file_id'])){

            $data['defaultpic'] = (isset($data['defaultpic']))?$data['defaultpic']:$data['file_id'][0];
            $data['brchead'] = (isset($data['brchead']))?$data['brchead']:$data['file_id'][0];
            $data['brc1'] = (isset($data['brc1']))?$data['brc1']:$data['file_id'][0];
            $data['brc2'] = (isset($data['brc2']))?$data['brc2']:$data['file_id'][0];
            $data['brc3'] = (isset($data['brc3']))?$data['brc3']:$data['file_id'][0];


            for($i = 0 ; $i < count($data['file_id']); $i++ ){


                $files[$data['file_id'][$i]]['thumbnail_url'] = $data['thumbnail_url'][$i];
                $files[$data['file_id'][$i]]['large_url'] = $data['large_url'][$i];
                $files[$data['file_id'][$i]]['medium_url'] = $data['medium_url'][$i];
                $files[$data['file_id'][$i]]['full_url'] = $data['full_url'][$i];

                $files[$data['file_id'][$i]]['delete_type'] = $data['delete_type'][$i];
                $files[$data['file_id'][$i]]['delete_url'] = $data['delete_url'][$i];
                $files[$data['file_id'][$i]]['filename'] = $data['filename'][$i];
                $files[$data['file_id'][$i]]['filesize'] = $data['filesize'][$i];
                $files[$data['file_id'][$i]]['temp_dir'] = $data['temp_dir'][$i];
                $files[$data['file_id'][$i]]['filetype'] = $data['filetype'][$i];
                $files[$data['file_id'][$i]]['fileurl'] = $data['fileurl'][$i];
                $files[$data['file_id'][$i]]['file_id'] = $data['file_id'][$i];
                $files[$data['file_id'][$i]]['caption'] = $data['caption'][$i];

                if($data['defaultpic'] == $data['file_id'][$i]){
                    $defaults['thumbnail_url'] = $data['thumbnail_url'][$i];
                    $defaults['large_url'] = $data['large_url'][$i];
                    $defaults['medium_url'] = $data['medium_url'][$i];
                    $defaults['full_url'] = $data['full_url'][$i];
                }

                if($data['brchead'] == $data['file_id'][$i]){
                    $defaults['brchead'] = $data['large_url'][$i];
                }

                if($data['brc1'] == $data['file_id'][$i]){
                    $defaults['brc1'] = $data['large_url'][$i];
                }

                if($data['brc2'] == $data['file_id'][$i]){
                    $defaults['brc2'] = $data['large_url'][$i];
                }

                if($data['brc3'] == $data['file_id'][$i]){
                    $defaults['brc3'] = $data['large_url'][$i];
                }


            }

        }else{

            $data['thumbnail_url'] = array();
            $data['large_url'] = array();
            $data['medium_url'] = array();
            $data['full_url'] = array();
            $data['delete_type'] = array();
            $data['delete_url'] = array();
            $data['filename'] = array();
            $data['filesize'] = array();
            $data['temp_dir'] = array();
            $data['filetype'] = array();
            $data['fileurl'] = array();
            $data['file_id'] = array();
            $data['caption'] = array();

            $data['defaultpic'] = '';
            $data['brchead'] = '';
            $data['brc1'] = '';
            $data['brc2'] = '';
            $data['brc3'] = '';
        }


        $data['defaultpictures'] = $defaults;
        $data['files'] = $files;

        return $data;
    }

    public function beforeUpdateForm($population)
    {
        //print_r($population);
        //exit();

        foreach( Prefs::getOutlet()->OutletToArray() as $o){

            $av = Stockunit::where('outletId', $o->_id )
                    ->where('productId', new MongoId($population['_id']) )
                    ->where('status','available')
                    ->count();

            $hd = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($population['_id']))
                    ->where('status','hold')
                    ->count();

            $rsv = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($population['_id']))
                    ->where('status','reserved')
                    ->count();

            $sld = Stockunit::where('outletId', $o->_id)
                    ->where('productId',new MongoId($population['_id']))
                    ->where('status','sold')
                    ->count();

            $population['stocks'][$o->_id]['available'] = $av;
            $population['stocks'][$o->_id]['hold'] = $hd;
            $population['stocks'][$o->_id]['reserved'] = $rsv;
            $population['stocks'][$o->_id]['sold'] = $sld;
        }

        if( !isset($population['full_url']))
        {
            $population['full_url'] = $population['large_url'];
        }
        return $population;
    }

    public function postAdd($data = null)
    {

        $this->validator = array(
            'SKU' => 'required',
            'category' => 'required',
            'itemDescription' => 'required',
            'priceRegular' => 'required',
        );

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {
        $this->validator = array(
            'SKU' => 'required',
            'category' => 'required',
            'itemDescription' => 'required',
            'priceRegular' => 'required',
        );

        return parent::postEdit($id,$data);
    }

    public function postDlxl()
    {

        $this->heads = null;

        $this->fields = array(
                array('SKU',array('kind'=>'text','query'=>'like','pos'=>'both','attr'=>array('class'=>'expander'),'show'=>true)),
                array('itemDescription',array('kind'=>'text','query'=>'like','pos'=>'both','attr'=>array('class'=>'expander'),'show'=>true)),
                array('series',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('itemGroup',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('category',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('L',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('W',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('H',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('D',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('colour',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('material',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('tags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
                array('createdDate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
                array('lastUpdate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true))
        );

        return parent::postDlxl();
    }

    public function getImport(){

        $this->importkey = 'SKU';

        return parent::getImport();
    }

    public function postUploadimport()
    {
        $this->importkey = 'SKU';

        return parent::postUploadimport();
    }

    public function beforeImportCommit($data)
    {
        $defaults = array();

        $files = array();

        // set new sequential ID


        $data['priceRegular'] = new MongoInt32($data['priceRegular']);

        $data['thumbnail_url'] = array();
        $data['large_url'] = array();
        $data['medium_url'] = array();
        $data['full_url'] = array();
        $data['delete_type'] = array();
        $data['delete_url'] = array();
        $data['filename'] = array();
        $data['filesize'] = array();
        $data['temp_dir'] = array();
        $data['filetype'] = array();
        $data['fileurl'] = array();
        $data['file_id'] = array();
        $data['caption'] = array();

        $data['defaultpic'] = '';
        $data['brchead'] = '';
        $data['brc1'] = '';
        $data['brc2'] = '';
        $data['brc3'] = '';


        $data['defaultpictures'] = array();
        $data['files'] = array();

        return $data;
    }


    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="fa fa-trash"></i> Delete</span>';
        $edit = '<a href="'.URL::to('products/edit/'.$data['_id']).'"><i class="fa fa-edit"></i> Update</a>';
        $dl = '<a href="'.URL::to('brochure/dl/'.$data['_id']).'" target="new"><i class="fa fa-download"></i> Download</a>';
        $print = '<a href="'.URL::to('brochure/print/'.$data['_id']).'" target="new"><i class="fa fa-print"></i> Print</a>';
        $upload = '<span class="upload" id="'.$data['_id'].'" rel="'.$data['SKU'].'" ><i class="fa fa-upload"></i> Upload Picture</span>';

        $actions = $edit.'<br />'.$upload.'<br />'.$delete;
        $actions = '';
        return $actions;
    }

    public function extractCategory()
    {
        $category = Product::distinct('category')->get()->toArray();
        $cats = array(''=>'All');

        //print_r($category);
        foreach($category as $cat){
            $cats[$cat[0]] = $cat[0];
        }

        return $cats;
    }

    public function splitTag($data){
        $tags = explode(',',$data['docTag']);
        if(is_array($tags) && count($tags) > 0 && $data['docTag'] != ''){
            $ts = array();
            foreach($tags as $t){
                $ts[] = '<span class="tag">'.$t.'</span>';
            }

            return implode('', $ts);
        }else{
            return $data['docTag'];
        }
    }

    public function splitShare($data){
        $tags = explode(',',$data['docShare']);
        if(is_array($tags) && count($tags) > 0 && $data['docShare'] != ''){
            $ts = array();
            foreach($tags as $t){
                $ts[] = '<span class="tag">'.$t.'</span>';
            }

            return implode('', $ts);
        }else{
            return $data['docShare'];
        }
    }


    public function namePic($data)
    {
        $name = HTML::link('property/view/'.$data['_id'],$data['address']);

        $thumbnail_url = '';

        //$data = $data->toArray();

        //print_r($data);

        //exit();

        if(isset($data['productDetail']['files']) && count($data['productDetail']['files'])){
            $glinks = '';

            $gdata = $data['productDetail']['files'][$data['productDetail']['defaultpic']];

            $thumbnail_url = $gdata['thumbnail_url'];
            foreach($data['productDetail']['files'] as $g){
                $g['caption'] = ($g['caption'] == '')?$data['propertyId']:$data['propertyId'].' : '.$g['caption'];
                $g['full_url'] = isset($g['full_url'])?$g['full_url']:$g['fileurl'];
                $glinks .= '<input type="hidden" class="g_'.$data['_id'].'" data-caption="'.$g['caption'].'" value="'.$g['full_url'].'" >';
            }

            $display = HTML::image($thumbnail_url.'?'.time(), $thumbnail_url, array('class'=>'thumbnail img-polaroid','style'=>'cursor:pointer;','id' => $data['_id'])).$glinks;
            return $display;
        }else{
            return $data['SKU'];
        }
    }

    public function dispBar($data)

    {
        $code = $data['unitId'];
        $display = HTML::image(URL::to('barcode/'.$code), $data['SKU'], array('id' => $data['_id'], 'style'=>'width:100px;height:auto;' ));
        $display = '<a href="'.URL::to('barcode/dl/'.$code).'">'.$display.'</a>';
        return $display.'<br />'.$data['SKU'];
    }

    public function shortunit($data){
        return substr($data['unitId'], -10);
    }

    public function toIdr($data, $field)
    {
        return '<h5 style="text-align:right;">'. Ks::idr( $data[$field] ) .'</h5>' ;
    }

    public function pics($data)
    {
        $name = HTML::link('products/view/'.$data['_id'],$data['productDetail']['productName']);
        if(isset($data['thumbnail_url']) && count($data['thumbnail_url'])){
            $display = HTML::image($data['thumbnail_url'][0].'?'.time(), $data['filename'][0], array('style'=>'min-width:100px;','id' => $data['_id']));
            return $display.'<br /><span class="img-more" id="'.$data['_id'].'">more images</span>';
        }else{
            return $name;
        }
    }

    public function getViewpics($id)
    {

    }

    public function trxDetail($trxid)
    {
        $itemtable = '';
        $session_id = $trxid;
        $trx = Transaction::where('sessionId',$session_id)->get()->toArray();
        $pay = Payment::where('sessionId',$session_id)->first()->toArray();

        //print_r($pay);

        $tab = array();
        foreach($trx as $t){

            $tab[ $t['SKU'] ]['description'] = $t['productDetail']['itemDescription'];
            $tab[ $t['SKU'] ]['qty'] = ( isset($tab[ $t['SKU'] ]['qty']) )? $tab[ $t['SKU'] ]['qty'] + 1:1;
            $tab[ $t['SKU'] ]['tagprice'] = $t['productDetail']['priceRegular'];
            $tab[ $t['SKU'] ]['total'] = ( isset($tab[ $t['SKU'] ]['total']) )? $tab[ $t['SKU'] ]['total'] + $t['productDetail']['priceRegular']:$t['productDetail']['priceRegular'];

        }

        $tab_data = array();
        $gt = 0;
        foreach($tab as $k=>$v){
            $tab_data[] = array(
                    array('value'=>$v['description'], 'attr'=>'class="left"'),
                    array('value'=>$v['qty'], 'attr'=>'class="center"'),
                    array('value'=>Ks::idr($v['tagprice']), 'attr'=>'class="right"'),
                    array('value'=>Ks::idr($v['total']), 'attr'=>'class="right" id="total_'.$k.'"'),
                );
            $gt += $v['total'];
        }

        //$gt += $gt * 0.1;


        $delivery_charge = ( isset($pay['delivery_charge']) )?$pay['delivery_charge']:0;
        $disc_pct = ( isset($pay['disc_pct']) )?$pay['disc_pct']:0;
        $tax = ( isset($pay['tax_pct']) )?$pay['tax_pct']:0;

        $total_discount = $gt * (doubleval($disc_pct) / 100);
        //$totalform = Former::hidden('totalprice',$gt);

        $total_payable = $gt - $total_discount;

        $total_tax = $total_payable  * (doubleval($tax) / 100);

        $total_payable = $total_payable + $total_tax + doubleval($delivery_charge);

        $totalform = Former::hidden('totalprice',$total_payable);

        $tab_data[] = array('','',array('value'=>'Sub Total', 'attr'=>'class="right"'),array('value'=>Ks::idr($gt), 'attr'=>'class="right"'));

        $tab_data[] = array('','',array('value'=>'Discount '.$disc_pct.'%', 'attr'=>'class="right"'),array('value'=>'- '.Ks::idr($total_discount), 'attr'=>'class="right"'));

        $tab_data[] = array('','',array('value'=>'PPN '.$tax.'%', 'attr'=>'class="right"'),array('value'=>Ks::idr($total_tax), 'attr'=>'class="right"'));

        $tab_data[] = array('','',array('value'=>'Shipping Charges', 'attr'=>'class="right"'),array('value'=>Ks::idr($delivery_charge), 'attr'=>'class="right"'));

        $tab_data[] = array('',$totalform,array('value'=>'Total', 'attr'=>'class="right bold"'),array('value'=>Ks::idr($total_payable), 'attr'=>'class="right bold"'));

        $header = array(
            'things to buy',
            'unit',
            array('value'=>'tag price', 'attr'=>'style="text-align:right"'),
            array('value'=>'price to pay', 'attr'=>'style="text-align:right"')
            );

        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($tab_data, $attr, $header);
        $itemtable = $t->build();

        return $itemtable;

    }


    public function updateStock($data){

        //print_r($data);

        $outlets = $data['outlets'];
        $outletNames = $data['outletNames'];
        $addQty = $data['addQty'];
        $adjustQty = $data['adjustQty'];

        unset($data['outlets']);
        unset($data['outletNames']);
        unset($data['addQty']);
        unset($data['adjustQty']);

        for( $i = 0; $i < count($outlets); $i++)
        {

            $su = array(
                    'outletId'=>$outlets[$i],
                    'outletName'=>$outletNames[$i],
                    'productId'=>$data['id'],
                    'SKU'=>$data['SKU'],
                    'productDetail'=>$data,
                    'status'=>'available',
                    'createdDate'=>new MongoDate(),
                    'lastUpdate'=>new MongoDate()
                );

            if($addQty[$i] > 0){
                for($a = 0; $a < $addQty[$i]; $a++){
                    $su['_id'] = str_random(40);
                    Stockunit::insert($su);
                }
            }

            if($adjustQty[$i] > 0){
                $td = Stockunit::where('outletId',$outlets[$i])
                    ->where('productId',$data['id'])
                    ->where('SKU', $data['SKU'])
                    ->where('status','available')
                    ->orderBy('createdDate', 'asc')
                    ->take($adjustQty[$i])
                    ->get();

                foreach($td as $d){
                    $d->status = 'deleted';
                    $d->lastUpdate = new MongoDate();
                    $d->save();
                }
            }
        }


    }

}
