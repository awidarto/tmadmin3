<?php

class Test {

    public static $category;
    public static $section;
    public static $faqcategory;
    public static $productcategory;
    public static $outlet;
    public static $role;
    public static $contactgroup;
    public static $newsletter;

    public function __construct()
    {

    }

    public static function getCategory(){
        $c = Category::get();
        self::$category = $c;
        return new self;
    }

    public static function getSection(){
        $s = Section::get();

        self::$section = $s;
        return new self;
    }

    public function sectionToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'All');
        }else{
            $ret = array();
        }

        foreach (self::$section as $s) {
            $ret[$s->{$value}] = $s->{$label};
        }

        return $ret;
    }


    public function catToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'All');
        }else{
            $ret = array();
        }

        foreach (self::$category as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function sectionToArray()
    {
        return self::$section;
    }

    public function catToArray()
    {
        return self::$category;
    }

    public static function getFAQCategory(){
        $c = Faqcat::get();

        self::$faqcategory = $c;
        return new self;
    }

    public function FAQcatToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'All');
        }else{
            $ret = array();
        }

        foreach (self::$faqcategory as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function FAQcatToArray()
    {
        return self::$faqcategory;
    }


    public static function getRole(){
        $c = Role::get();

        self::$role = $c;
        return new self;
    }

    public function RoleToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'Select Role');
        }else{
            $ret = array();
        }

        foreach (self::$role as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function RoleToArray()
    {
        return self::$role;
    }

    public static function getProductCategory(){
        $c = Productcategory::get();

        self::$productcategory = $c;
        return new self;
    }

    public function ProductCatToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'Select Category');
        }else{
            $ret = array();
        }

        foreach (self::$productcategory as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function ProductCatToArray()
    {
        return self::$productcategory;
    }


    public static function getOutlet(){
        $c = Outlet::get();

        self::$outlet = $c;
        return new self;
    }

    public function OutletToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'Select Outlet');
        }else{
            $ret = array();
        }

        foreach (self::$outlet as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function OutletToArray()
    {
        return self::$outlet;
    }

    //contact group
    public static function getContactGroup(){
        $c = Contactgroup::get();

        self::$category = $c;
        return new self;
    }

    public function contactGroupToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'All');
        }else{
            $ret = array();
        }

        foreach (self::$category as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function contactGroupToArray()
    {
        return self::$category;
    }


    //newsletter
    public static function getNewsletter(){
        $c = Template::where('type','newsletter')->get();

        self::$newsletter = $c;
        return new self;
    }

    public function newsletterToSelection($value, $label, $all = true)
    {
        if($all){
            $ret = array(''=>'All');
        }else{
            $ret = array();
        }

        foreach (self::$newsletter as $c) {
            $ret[$c->{$value}] = $c->{$label};
        }


        return $ret;
    }

    public function newsletterToArray()
    {
        return self::$newsletter;
    }

    public static function getPrincipal(){
        $c = Principal::get();

        self::$principal = $c;

        return new self;
    }


    public static function yearSelection(){
        $ya = array();
        for( $i = 1970; $i < 2050; $i++ ){
            $ya[$i] = $i;
        }
        return $ya;
    }

    public static function GetBatchId($SKU, $year, $month){

        $seq = DB::collection('batchnumbers')->raw();

        $new_id = $seq->findAndModify(
                array(
                    'SKU'=>$SKU,
                    'year'=>$year,
                    'month'=>$month
                    ),
                array('$inc'=>array('sequence'=>1)),
                null,
                array(
                    'new' => true,
                    'upsert'=>true
                )
            );


        $batchid = $year.$month.str_pad($new_id['sequence'], 4, '0', STR_PAD_LEFT);

        return $batchid;

    }

    public static function GetInvoiceSequence($prefix, $pad = 5, $infix = '', $suffix = ''){

        $seq = DB::collection('invoicesequences')->raw();

        $new_id = $seq->findAndModify(
                array(
                    'prefix'=>$prefix
                    ),
                array('$inc'=>array('sequence'=>1)),
                null,
                array(
                    'new' => true,
                    'upsert'=>true
                )
            );


        $invseq = $prefix.$infix.str_pad($new_id['sequence'], $pad, '0', STR_PAD_LEFT).$suffix;

        return $invseq;

    }

    public static function ExtractProductCategory($selection = true)
    {   

        $c = new Product();


        $collection = $c->category;

        $category = Product::all();

        //$data = $collection->find->all()->toArray();

       // $category = Product::distinct('category')->get()->toArray();
        if($selection){
            $cats = array(''=>'All');
        }else{
            $cats = array();
        }

        //print_r($category);
        foreach($category as $cat){
            $cats[$cat[0]] = $cat[0];
        }

        return $cats;
    }


    public static function themeAssetsUrl()
    {
        return URL::to('/').'/'.Theme::getCurrentTheme();
    }

    public static function themeAssetsPath()
    {
        return 'themes/'.Theme::getCurrentTheme().'/assets/';
    }

    public static function getActiveTheme()
    {
        return Config::get('kickstart.default_theme');
    }

    public static function getPrintDefault($type = 'asset'){
        $printdef = Printdefault::where('ownerId',Auth::user()->_id)
                        ->where('type',$type)
                        ->first();
        if($printdef){
            return $printdef;
        }else{
            $d = new stdClass();
            $d->col = 2;
            $d->res = 150;
            $d->cell_width = 250;
            $d->cell_height = 300;
            $d->margin_right = 8;
            $d->margin_bottom = 10;
            $d->font_size = 8;
            $d->code_type = 'qr';

            return $d;
        }
    }

}
