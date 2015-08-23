<?php

class SalesreportController extends AdminController {

    public function __construct()
    {
        parent::__construct();

        $this->controller_name = str_replace('Controller', '', get_class());

        //$this->crumb = new Breadcrumb();
        //$this->crumb->append('Home','left',true);
        //$this->crumb->append(strtolower($this->controller_name));

        $this->model = new Sales();
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
            array('Transaction Id',array('search'=>true,'sort'=>true)),
            array('Status',array('search'=>true,'sort'=>true)),
            array('Outlet',array('search'=>true,'sort'=>true, 'select'=>Prefs::getOutlet()->OutletToSelection('name','name') )),
            array('Buyer',array('search'=>true,'sort'=>false)),
            array('Address',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Total',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Cash',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Debit',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Credit Card',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        //print $this->model->where('docFormat','picture')->get()->toJSON();

        $this->title = 'Sales Report';

        $this->additional_filter = View::make('salesreport.addfilter')->render();

        $this->js_table_event = View::make('salesreport.jstableevent')->render();

        $this->js_additional_param = "aoData.push( { 'name':'outletNameFilter', 'value': $('#outlet-filter').val() } );";

        $this->place_action ='first';

        $this->can_add = false;

        return parent::getIndex();

    }

    public function postIndex()
    {

        $this->fields = array(

            array('sessionId',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('transactionstatus',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('outletName',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('buyer_name',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('buyer_address',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('payable_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr' )),
            array('cash_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr')),
            array('dc_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr')),
            array('cc_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true, 'callback'=>'toIdr')),
            array('createdDate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
        );

        $outletFilter = Input::get('outletNameFilter');

        if($outletFilter != ''){
            $this->additional_query = array('outletName'=>$outletFilter);
        }


        $this->place_action ='first';

        return parent::postIndex();
    }

    public function getDetail($id){
        $sales = Sales::find($id)->toArray();

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

        $btab[] = array('Current Status',$transactionstatus);
        $btab[] = array('Outlet',$sales['outletName']);
        $btab[] = array('Transaction Type',(isset($sales['transactiontype']))?$sales['transactiontype']:'' );

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

        return View::make('salesreport.detail')
                ->with('tablebuyer',$tablebuyer)
                ->with('tablepurchase',$tablepurchase)
                ->with('tableshipment',$tableshipment)
                ->with('tabletrans',$tabletrans);
    }

    //public function getPrintlabel($sessionname, $columns = 2, $resolution = 150,$cell_width = 120,$cell_height = 75, $margin_right = 10,$margin_bottom = 20,$font_size = 8,$code_type = 'barcode', $left_offset = 0, $top_offset = 0, $format = 'html' )
    public function getPrintlabel($sessionname, $printparam, $format = 'html' )
    {
        $pr = explode(':',$printparam);

        $columns = $pr[0];
        $resolution = $pr[1];
        $cell_width = $pr[2];
        $cell_height = $pr[3];
        $margin_right = $pr[4];
        $margin_bottom = $pr[5];
        $font_size = $pr[6];
        $code_type = $pr[7];
        $left_offset = $pr[8];
        $top_offset = $pr[9];

        $session = Printsession::find($sessionname)->toArray();
        $labels = Stockunit::whereIn('_id', $session)->get()->toArray();

        $skus = array();
        foreach($labels as $l){
            $skus[] = $l['SKU'];
        }

        $skus = array_unique($skus);

        $products = Product::whereIn('SKU',$skus)->get()->toArray();

        $plist = array();
        foreach($products as $product){
            $plist[$product['SKU']] = $product;
        }

        return View::make('inventory.printlabel')
            ->with('columns',$columns)
            ->with('resolution',$resolution)
            ->with('cell_width',$cell_width)
            ->with('cell_height',$cell_height)
            ->with('margin_right',$margin_right)
            ->with('margin_bottom',$margin_bottom)
            ->with('font_size',$font_size)
            ->with('code_type',$code_type)
            ->with('left_offset', $left_offset)
            ->with('top_offset', $top_offset)
            ->with('products',$plist)
            ->with('labels', $labels);
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

        $this->heads = array(
            array('Transaction Id',array('search'=>true,'sort'=>true)),
            array('Status',array('search'=>true,'sort'=>true)),
            array('Outlet',array('search'=>true,'sort'=>true )),
            array('Buyer',array('search'=>true,'sort'=>false)),
            array('Address',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Total',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Cash',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Debit',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Credit Card',array('search'=>true,'sort'=>false ,'attr'=>array('class'=>''))),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $this->fields = array(
            array('sessionId',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('transactionstatus',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('outletName',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('buyer_name',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('buyer_address',array('kind'=>'text','query'=>'like','pos'=>'after','show'=>true)),
            array('payable_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true )),
            array('cash_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true)),
            array('dc_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true)),
            array('cc_amount',array('kind'=>'numeric','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
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
        $dl = '<a href="'.URL::to('salesreport/dl/'.$data['_id']).'" target="new"><i class="fa fa-download"></i> Download</a>';
        $print = '<a href="'.URL::to('salesreport/print/'.$data['_id']).'" target="new"><i class="fa fa-print"></i> Print</a>';
        $upload = '<span class="upload action" id="'.$data['_id'].'" rel="'.$data['SKU'].'" ><i class="fa fa-upload"></i> Upload Picture</span>';
        $outlet = '<span class="outlet action" id="'.$data['_id'].'" rel="'.$data['SKU'].'" ><i class="fa fa-external-link"></i> Move Outlet</span>';
        $printcode = '<span class="printcode action" id="'.$data['_id'].'" ><i class="fa fa-print"></i> Print Code</span>';
        $view = '<span class="viewdetail action" id="'.$data['_id'].'" ><i class="fa fa-eye"></i> View Detail</span>';

        //$actions = $edit.'<br />'.$upload.'<br />'.$delete;
        $actions = $view;
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

    public function toIdr($data, $field)
    {
        return '<span style="display:block;text-align:right;font-weight:bold;">IDR '. Ks::idr( $data[$field] ) .'</span>' ;
    }

    public function itemDesc($data)
    {
        return $data['SKU'].'<br />'.$data['productDetail']['itemDescription'];
    }

    public function unitPrice($data)
    {
        return Ks::idr($data['productDetail']['priceRegular']);
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
        $code = $data['SKU'].'|'.substr($data['_id'], -10 );
        $code = urlencode($code);
        $display = HTML::image(URL::to('barcode/'.$code), $data['SKU'], array('id' => $data['_id'], 'style'=>'width:100px;height:auto;' ));
        $display = '<a href="'.URL::to('barcode/dl/'.$code).'">'.$display.'</a>';
        return $display.'<br />'.$data['SKU'];
    }

    public function shortunit($data){
        return substr($data['_id'], -10);
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
            'tagprice',
            array('value'=>'price to pay', 'attr'=>'style="text-align:right"')
            );

        $attr = array('class'=>'table', 'id'=>'transTab', 'style'=>'width:100%;', 'border'=>'0');
        $t = new HtmlTable($tab_data, $attr, $header);
        $itemtable = $t->build();

        return $itemtable;

    }


}
