<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::controller('inventory', 'InventoryController');
Route::controller('pos', 'PosController');
Route::controller('document', 'DocumentController');
Route::controller('property', 'PropertyController');
Route::controller('products', 'ProductsController');
Route::controller('productcategory', 'ProductcategoryController');
Route::controller('transaction', 'TransactionController');
Route::controller('outlet', 'OutletController');
Route::controller('user', 'UserController');
Route::controller('agent', 'AgentController');
Route::controller('buyer', 'BuyerController');
Route::controller('report', 'ReportController');
Route::controller('showcase', 'ShowcaseController');
Route::controller('pages', 'PagesController');
Route::controller('posts', 'PostsController');
Route::controller('category', 'CategoryController');
Route::controller('section', 'SectionController');
Route::controller('menu', 'MenuController');

Route::controller('event', 'EventController');

Route::controller('faq', 'FaqController');
Route::controller('faqcat', 'FaqcatController');

Route::controller('picture','PictureController');

Route::controller('enquiry', 'EnquiryController');

Route::controller('order', 'OrderController');
Route::controller('salesreport', 'SalesreportController');

Route::controller('newsletter', 'NewsletterController');
Route::controller('campaign', 'CampaignController');
Route::controller('contactgroup', 'ContactgroupController');

Route::controller('brochure', 'BrochureController');
Route::controller('option', 'OptionController');

Route::controller('glossary', 'GlossaryController');

Route::controller('activity', 'ActivityController');

Route::controller('inprop', 'InpropController');

Route::controller('templates', 'TemplatesController');

Route::controller('music', 'MusicController');
Route::controller('video', 'VideoController');
Route::controller('event', 'EventController');

Route::controller('scanner', 'ScannerController');

Route::controller('stockcheck', 'StockcheckController');
Route::controller('stockchecklist', 'StockchecklistController');
Route::controller('dashboard', 'DashboardController');

Route::controller('upload', 'UploadController');
Route::controller('ajax', 'AjaxController');

Route::controller('home', 'HomeController');
Route::controller('homeslide', 'HomeslideController');
Route::controller('header', 'HeaderController');

//Route::get('/', 'ProductsController@getIndex');
//Route::get('/', 'PosController@getIndex');
Route::get('/', 'DashboardController@getIndex');


Route::get('content/pages', 'PagesController@getIndex');
Route::get('content/posts', 'PostsController@getIndex');
Route::get('content/category', 'CategoryController@getIndex');
Route::get('content/section', 'SectionController@getIndex');
Route::get('content/menu', 'MenuController@getIndex');



Route::get('regenerate',function(){
    $property = new Property();

    $props = $property->get()->toArray();

    $seq = new Sequence();

    foreach($props as $p){

        $_id = new MongoId($p['_id']);

        $nseq = $seq->getNewId('property');

        $sdata = array(
            'sequence'=>$nseq,
            'propertyId' => Config::get('ia.property_id_prefix').$nseq
            );

        if( $property->where('_id','=', $_id )->update( $sdata ) ){
            print $p['_id'].'->'.$sdata['propertyId'].'<br />';
        }

    }

});

Route::get('tonumber',function(){
    $property = new Property();

    $props = $property->get()->toArray();

    $seq = new Sequence();

    foreach($props as $p){

        $_id = new MongoId($p['_id']);

        $price = new MongoInt32( $p['listingPrice'] );
        $fmv = new MongoInt32( $p['FMV'] );

        $sdata = array(
            'listingPrice'=>$price,
            'FMV'=>$fmv
            );

        if( $property->where('_id','=', $_id )->update( $sdata ) ){
            print $p['_id'].'->'.$sdata['listingPrice'].'<br />';
        }

    }

});

Route::get('regeneratepic/{obj?}',function($obj = null){

    set_time_limit(0);

    if(is_null($obj)){
        $product = new Product();
    }else{
        switch($obj){
            case 'product' :
                        $product = new Product();
                        break;
            case 'page' :
                        $product = new Page();
                        break;
            case 'post' :
                        $product = new Posts();
                        break;
            default :
                        $product = new Product();
                        break;
        }
    }

    $props = $product->get();

    //$seq = new Sequence();

    $sizes = Config::get('picture.sizes');

    foreach($props as $p){

        if(isset($p->files)){
            $files = $p->files;

            foreach($files as $folder=>$files){

                $dir = public_path().'/storage/media/'.$folder;

                if (is_dir($dir) && file_exists($dir)) {
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if($file != '.' && $file != '..'){
                                if(!preg_match('/^lrg_|med_|th_|full_/', $file)){
                                    echo $dir.'/'.$file."\n";

                                    $destinationPath = $dir;
                                    $filename = $file;

                                    $urls = array();

                                    foreach($sizes as $k=>$v){
                                        $thumbnail = Image::make($destinationPath.'/'.$filename)
                                            ->fit($v['width'],$v['height'])
                                            //->insert($sm_wm,0,0, 'bottom-right')
                                            ->save($destinationPath.'/'.$v['prefix'].$filename);
                                    }
                                    /*
                                    $thumbnail = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['thumbnail']['width'] ,$sizes['thumbnail']['height'])
                                        ->save($destinationPath.'/th_'.$filename);

                                    $medium = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['medium']['width'] ,$sizes['medium']['height'])
                                        ->save($destinationPath.'/med_'.$filename);

                                    $large = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['large']['width'] ,$sizes['large']['height'])
                                        ->save($destinationPath.'/lrg_'.$filename);

                                    $full = Image::make($destinationPath.'/'.$filename)
                                        ->fit( $sizes['full']['width'] ,$sizes['full']['height'])
                                        ->save($destinationPath.'/full_'.$filename);
                                    */
                                }
                            }
                        }
                        closedir($dh);
                    }
                }
            }

        }



    }

});

Route::get('pdf',function(){
    $content = "
    <page>
        <h1>Exemple d'utilisation</h1>
        <br>
        Ceci est un <b>exemple d'utilisation</b>
        de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
    </page>";

    $html2pdf = new HTML2PDF();
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf','D');
});

/*
Route::get('brochure/dl/{id}',function($id){

    $prop = Property::find($id)->toArray();

    //return View::make('print.brochure')->with('prop',$prop)->render();

    $content = View::make('print.brochure')->with('prop',$prop)->render();

    //return $content;

    return PDF::loadView('print.brochure',array('prop'=>$prop))
        ->stream('download.pdf');
});

Route::get('brochure',function(){
    View::make('print.brochure');
});
*/

Route::get('inc/{entity}',function($entity){

    $seq = new Sequence();
    print_r($seq->getNewId($entity));

});

Route::get('last/{entity}',function($entity){

    $seq = new Sequence();
    print( $seq->getLastId($entity) );

});

Route::get('init/{entity}/{initial}',function($entity,$initial){

    $seq = new Sequence();
    print_r( $seq->setInitialValue($entity,$initial));

});

Route::get('hashme/{mypass}',function($mypass){

    print Hash::make($mypass);
});

Route::get('xtest',function(){
    Excel::load('WEBSITE_INVESTORS_ALLIANCE.xlsx')->calculate()->dump();
});

Route::get('xcat',function(){
    print_r(Prefs::getCategory());
});

Route::get('barcode/dl/{txt}',function($txt){
    $barcode = new Barcode();
    $barcode->make($txt,'code128',60, 'horizontal' ,true);
    return $barcode->render('jpg',$txt,true);
});

Route::get('barcode/{txt}',function($txt){
    $barcode = new Barcode();
    $barcode->make($txt,'code128',60, 'horizontal' ,true);
    return $barcode->render('jpg',$txt);
});

Route::get('media',function(){
    $media = Product::all();

    print $media->toJson();

});

Route::get('login',function(){
    return View::make('login')->with('title','Sign In');
});

Route::post('login',function(){

    // validate the info, create rules for the inputs
    $rules = array(
        'email'    => 'required|email',
        'password' => 'required|alphaNum|min:3'
    );

    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);

    // if the validator fails, redirect back to the form
    if ($validator->fails()) {
        return Redirect::to('login')->withErrors($validator);
    } else {

        $userfield = Config::get('kickstart.user_field');
        $passwordfield = Config::get('kickstart.password_field');

        // find the user
        $user = User::where($userfield, '=', Input::get('email'))->first();


        // check if user exists
        if ($user) {
            // check if password is correct
            if (Hash::check(Input::get('password'), $user->{$passwordfield} )) {

                //print $user->{$passwordfield};
                //exit();
                // login the user
                Auth::login($user);

                return Redirect::to('/');

            } else {
                // validation not successful
                // send back to form with errors
                // send back to form with old input, but not the password
                return Redirect::to('login')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            }

        } else {
            // user does not exist in database
            // return them to login with message
            Session::flash('loginError', 'This user does not exist.');
            return Redirect::to('login');
        }

    }

});

Route::get('logout',function(){
    Auth::logout();
    return Redirect::to('/');
});

/* Filters */

Route::filter('auth', function()
{

    if (Auth::guest()){
        Session::put('redirect',URL::full());
        return Redirect::to('login');
    }

    if($redirect = Session::get('redirect')){
        Session::forget('redirect');
        return Redirect::to($redirect);
    }

    //if (Auth::guest()) return Redirect::to('login');
});
