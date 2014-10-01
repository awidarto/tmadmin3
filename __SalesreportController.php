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
        $this->place_action = 'first';

        $this->additional_filter = View::make('salesreport.addfilter')->render();

        $this->js_additional_param = "aoData.push( { 'name':'outletNameFilter', 'value': $('#outlet-filter').val() } );";


        $this->show_select = false;
        $this->title = 'Sales Report';

        return parent::getIndex();

    }

    public function shortunit($data){
        return substr($data['unitId'], -10);
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


    public function postIndex()
    {
/*
'sessionId' => 'HU2fJ',
  'createdDate' => new MongoDate(1412167345, 750000),
  'outletId' => '53563e12ccae5b180200001f',
  'outletName' => 'Toimoi Online Website',
  'buyer_name' => '',
  'buyer_address' => '',
  'cc_amount' => '',
  'cc_number' => '',
  'cc_expiry' => '',
  'dc_amount' => '',
  'dc_number' => '',
  'payable_amount' => '330000',
  'cash_amount' => '350000',
  'cash_change' => '20000',
*/
        $this->fields = array(
            array('sessionId',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
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

        $this->place_action = 'first';

        $this->def_order_by = 'sessionId';

        $this->def_order_dir = 'desc';

        $session = Input::get('session');

        $session = (is_null($session) || !isset($session))?'':$session;

        $outletFilter = Input::get('outletNameFilter');

        if($outletFilter != ''){
            $this->additional_query = array('outletName'=>$outletFilter);
        }

        $this->show_select = false;
        //$this->additional_query = array('distinct'=>'sessionId');

        return parent::postIndex();
    }

    public function beforeSave($data)
    {
        $defaults = array();

        $files = array();

        // set new sequential ID
        $sequence = new Sequence();

        $seq = $sequence->getNewId('property');

        $data['sequence'] = $seq;

        $data['propertyId'] = Config::get('ia.property_id_prefix').$seq;

        if($data['submit'] == 'Publish'){
            $data['publishStatus'] = 'published';
        }else{
            $data['publishStatus'] = 'draft';
        }

        $data['publishDate'] = $data['lastUpdate'];

        if( isset($data['file_id']) && count($data['file_id'])){

            $data['defaultpic'] = (isset($data['defaultpic']))?$data['defaultpic']:$data['file_id'][0];

            for($i = 0 ; $i < count($data['thumbnail_url']);$i++ ){

                if($data['defaultpic'] == $data['file_id'][$i]){
                    $defaults['thumbnail_url'] = $data['thumbnail_url'][$i];
                    $defaults['large_url'] = $data['large_url'][$i];
                    $defaults['medium_url'] = $data['medium_url'][$i];
                }

                $files[$data['file_id'][$i]]['thumbnail_url'] = $data['thumbnail_url'][$i];
                $files[$data['file_id'][$i]]['large_url'] = $data['large_url'][$i];
                $files[$data['file_id'][$i]]['medium_url'] = $data['medium_url'][$i];

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
        $data['files'] = $files;

        return $data;
    }

    public function beforeUpdate($id,$data)
    {
        $defaults = array();

        $files = array();

        if($data['submit'] == 'Publish'){
            $data['publishStatus'] = 'published';
        }else{
            $data['publishStatus'] = 'draft';
        }

        $data['publishDate'] = $data['lastUpdate'];


        if( isset($data['file_id']) && count($data['file_id'])){

            $data['defaultpic'] = (isset($data['defaultpic']))?$data['defaultpic']:$data['file_id'][0];


            for($i = 0 ; $i < count($data['file_id']); $i++ ){


                $files[$data['file_id'][$i]]['thumbnail_url'] = $data['thumbnail_url'][$i];
                $files[$data['file_id'][$i]]['large_url'] = $data['large_url'][$i];
                $files[$data['file_id'][$i]]['medium_url'] = $data['medium_url'][$i];

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
                }

            }

        }else{

            $data['thumbnail_url'] = array();
            $data['large_url'] = array();
            $data['medium_url'] = array();
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
        $data['files'] = $files;

        return $data;
    }

    public function postAdd($data = null)
    {

        $this->validator = array(
            'number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'type' => 'required',
            'yearBuilt' => 'required',
            'FMV' => 'required',
            'listingPrice' => 'required'
        );

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {
        $this->validator = array(
            'number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'type' => 'required',
            'yearBuilt' => 'required',
            'FMV' => 'required',
            'listingPrice' => 'required'
        );

        return parent::postEdit($id,$data);
    }

    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="fa fa-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('property/edit/'.$data['_id']).'"><i class="fa fa-edit"></i>Update</a>';

        $actions = $edit.'<br />'.$delete;
        return $actions;
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

        if(isset($data['files']) && count($data['files'])){
            $glinks = '';

            $gdata = $data['files'][$data['defaultpic']];

            $thumbnail_url = $gdata['thumbnail_url'];
            foreach($data['files'] as $g){
                $glinks .= '<input type="hidden" class="g_'.$data['_id'].'" data-caption="'.$g['caption'].'" value="'.$g['fileurl'].'" >';
            }

            $display = HTML::image($thumbnail_url.'?'.time(), $thumbnail_url, array('class'=>'thumbnail img-polaroid','id' => $data['_id'])).$glinks;
            return $display;
        }else{
            return $name;
        }
    }

    public function pics($data)
    {
        $name = HTML::link('products/view/'.$data['_id'],$data['productName']);
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


}
