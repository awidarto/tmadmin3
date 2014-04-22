<?php

class AjaxController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | The Default Controller
    |--------------------------------------------------------------------------
    |
    | Instead of using RESTful routes and anonymous functions, you might wish
    | to use controllers to organize your application API. You'll love them.
    |
    | This controller responds to URIs beginning with "home", and it also
    | serves as the default controller for the application, meaning it
    | handles requests to the root of the application.
    |
    | You can respond to GET requests to "/home/profile" like so:
    |
    |       public function action_profile()
    |       {
    |           return "This is your profile!";
    |       }
    |
    | Any extra segments are passed to the method as parameters:
    |
    |       public function action_profile($id)
    |       {
    |           return "This is the profile for user {$id}.";
    |       }
    |
    */

    public function __construct(){

    }

    public function getIndex()
    {
    }

    public function postIndex()
    {

    }

    public function postScan()
    {
        $in = Input::get();

        $attid = trim( strtoupper($in['txtin']));

        //$guest = Attendee::find($attid);

        $guest = Attendee::where('hcode','=',$attid)->first();

        $attendee = false;

        $tabstat = false;

        if($guest){
            $attendee = $guest->toArray();
            if( isset($guest->scanned) && $guest->scanned >= 1){
                //$guest->attending = $guest->attending + 1;
                $guest->scanned = $guest->scanned + 1;
                $guest->save();

                if(date('Y-m-d',time()) == '2014-03-14' || Config::get('seater.is_gala') == true ){
                    $instat = '<h1>Welcome back to Gala Dinner</h1>';
                }else{
                    $instat = '<h1>Welcome back to</h1>';
                }

                $instat .= '<h1>'.Config::get('seater.event_name').' !</h1>';

                $statcount = Attendee::where('tableNumber','=',$guest->tableNumber)
                    ->where('seatNumber','=',$guest->seatNumber)
                    ->where('attending','=',1)
                    ->count();
                $res = 'NOK';
            }else{

                $guest->attending = 1;
                $guest->scanned = 1;
                $guest->save();
                if(date('Y-m-d',time()) == '2014-03-14' || Config::get('seater.is_gala') == true ){
                    $instat = '<h1>Welcome, to Gala Dinner</h1>';
                }else{
                    $instat = '<h1>Welcome, to</h1>';
                }
                $instat .= '<h1>'.Config::get('seater.event_name').' !</h1>';

                $statcount = Attendee::where('tableNumber','=',$guest->tableNumber)
                    ->where('seatNumber','=',$guest->seatNumber)
                    ->where('attending','=',1)
                    ->count();

                $res = 'OK';
            }

            $logdata = $attendee;

            $logdata['guest_id'] = $logdata['_id'];
            unset($logdata['_id']);
            $attlog = new Attendancelog();

            foreach($logdata as $k=>$v){
                $attlog->{$k} = $v;
            }

            $attlog->createdDate = new MongoDate();
            $attlog->lastUpdate = new MongoDate();

            $attlog->save();

        }else{
            $instat = 'Unregistered guest code.';
            $res = 'NOK';
        }


        $attending = Attendee::where('attending','=',1)->get()->toArray();

        $ts = array();

        foreach ($attending as $att) {
            $tidx = $att['type'].'-'.$att['tableNumber'];
            if(isset($ts[$tidx])){
                $ts[$tidx] = $ts[$tidx] + 1;
            }else{
                $ts[$tidx] = 1;
            }
        }

        $tabstat = $ts;
        /*
        $tabstat = array();
        foreach($ts as $key=>$value){
            $tabstat[] = array('id'=>$key,'val'=>$value);
        }
        */

        $result = array(
            'attendee'=>$attendee,
            'tabstat'=>$tabstat,
            'html'=>$instat,
            'result'=>$res
        );

        return Response::json($result);
    }

    public function postScancheck()
    {
        $in = Input::get();

        $code = $in['txtin'];
        $outlet_id = $in['outlet_id'];

        $res = 'OK';


        if(strripos($code, '|')){
            $code = explode('|', $code);
            $SKU = $code[0];
            $unit_id = $code[1];

            $u = Stockunit::where('outletId','=', $outlet_id)
                    ->where('SKU','=', $SKU)
                    ->where('_id', 'like', '%'.$unit_id )
                    ->first();

            if($u){

                $u = $u->toArray();

                $u['scancheckDate'] = new MongoDate();
                $u['createdDate'] = new MongoDate();
                $u['lastUpdate'] = new MongoDate();

                $unit_id = $u['_id'];

                unset($u['_id']);

                $u['unitId'] = $unit_id;

                Stockunitlog::insert($u);

                $res = 'OK';
                $msg = 'Unit scanned in : SKU '.$u['SKU'].' - '.$unit_id.' successfuly checked in';

            }else{
                $res = 'NOK';
                $msg = 'Unit scanned in : SKU '.$SKU.' - '.$unit_id.' failed to check';
            }

        }else{
            $SKU = trim($code);

            $u = Stockunit::where('outletId','=',$outlet_id)
                    ->where('SKU','=',$SKU)
                    ->first();

            if($u){

                $u = $u->toArray();

                $u['scancheckDate'] = new MongoDate();
                $u['createdDate'] = new MongoDate();
                $u['lastUpdate'] = new MongoDate();

                $unit_id = $u['_id'];

                unset($u['_id']);

                $u['unitId'] = $unit_id;

                Stockunitlog::insert($u);

                $res = 'OK';
                $msg = 'Unit scanned in : SKU '.$u['SKU'].' - '.$unit_id.' successfuly checked in';;
            }else{
                $res = 'NOK';
                $msg = 'Unit scanned in : SKU '.$SKU.' failed to check';
            }

        }


        $result = array(
            'result'=>$res,
            'msg'=>$msg
        );

        return Response::json($result);
    }

    public function postProductinfo(){
        $pid = Input::get('product_id');

        $p = Product::find($pid);

        if($p){
            return Response::json(array('result'=>'OK:FOUND', 'data'=>$p->toArray() ));
        }else{
            return Response::json(array('result'=>'ERR:NOTFOUND'));
        }


    }

    public function postProductpicture(){
        $data = Input::get();


        $defaults = array();

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

        $p = Product::find($data['upload_id']);

        $p->thumbnail_url =  $data['thumbnail_url'];
        $p->large_url =  $data['large_url'];
        $p->medium_url =  $data['medium_url'];
        $p->full_url =  $data['full_url'];
        $p->delete_type =  $data['delete_type'];
        $p->delete_url =  $data['delete_url'];
        $p->filename =  $data['filename'];
        $p->filesize =  $data['filesize'];
        $p->temp_dir =  $data['temp_dir'];
        $p->filetype =  $data['filetype'];
        $p->fileurl =  $data['fileurl'];
        $p->file_id =  $data['file_id'];
        $p->caption =  $data['caption'];
        $p->defaultpic =  $data['defaultpic'];
        $p->brchead =  $data['brchead'];
        $p->brc1 =  $data['brc1'];
        $p->brc2 =  $data['brc2'];
        $p->brc3 =  $data['brc3'];
        $p->defaultpictures =  $data['defaultpictures'];
        $p->files =  $data['files'];

        if($p->save()){
            return Response::json(array('result'=>'OK:UPLOADED' ));
        }else{
            return Response::json(array('result'=>'ERR:UPDATEFAILED' ));
        }

    }

    public function getPlaylist(){
        $mc = LMongo::collection('playlist');

        $video = $mc
            ->orderBy('sequence', 'asc')
            ->get();

        $playlist = array();

        foreach($video as $v){
            $playlist[] = array('file'=>$v['url']);
        }

        return Response::json($playlist);
    }

    public function getPush(){
        $lockfile = realpath('storage/lock').'/push';
        file_put_contents($lockfile, '1');
        return Response::json(array('push'=>1));
    }

    public function getChange(){
        $lockfile = realpath('storage/lock').'/push';

        $change = file_get_contents($lockfile);

        if($change == 1){
            file_put_contents($lockfile, '2');
            return Response::json(array('push'=>1));
        }else{
            return Response::json(array('push'=>0));
        }
    }

    public function getTag()
    {
        $q = Input::get('term');

        $tag = LMongo::collection('products');
        $qtag = new MongoRegex('/'.$q.'/i');

        $res = $tag->where('tag',$qtag)->get();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['tag'],'label'=>$r['tag'],'value'=>$r['tag']);
        }

        return Response::json($result);
    }


    public function getProduct()
    {
        $q = Input::get('term');

        $user = new Product();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('name'=>$qemail),array('description'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $display = HTML::image(URL::base().'/storage/products/'.$r['_id'].'/sm_pic0'.$r['defaultpic'].'.jpg?'.time(), 'sm_pic01.jpg', array('id' => $r['_id']));
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['name'],'link'=>$r['permalink'],'pic'=>$display,'description'=>$r['description'],'label'=>$r['name']);
        }

        return Response::json($result);
    }

    public function getProductplain()
    {
        $q = Input::get('term');

        $user = new Product();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('name'=>$qemail),array('description'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['permalink'],'description'=>$r['description'],'label'=>$r['name']);
        }

        return Response::json($result);
    }

    public function getEmail()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ),array('email','fullname'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['email'],'name'=>$r['fullname'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getUser()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ),array('email','fullname'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getGroup()
    {
        $q = Input::get('term');

        $user = new Group();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('firstname'=>$qemail),array('lastname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['groupname'],'email'=>$r['email'],'label'=>$r['groupname'].'<br />'.$r['firstname'].''.$r['lastname'].' ( '.$r['email'].' )<br />'.$r['company']);
        }

        return Response::json($result);
    }

    public function getUserdata()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUserdatabyemail()
    {
        $q = Input::get('term');

        $user = LMongo::collection('users');

        $qemail = new MongoRegex('/'.$q.'/i');



        $res = $user->whereRegex('username',$qemail)->orWhereRegex('fullname',$qemail)->get();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['username'],'email'=>$r['username'],'label'=>$r['fullname'].' ( '.$r['username'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUserdatabyname()
    {
        $q = Input::get('term');

        $user = LMongo::collection('users');

        $qemail = new MongoRegex('/'.$q.'/i');



        $res = $user->whereRegex('username',$qemail)->orWhereRegex('fullname',$qemail)->get();

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['fullname'],'email'=>$r['username'],'label'=>$r['fullname'].' ( '.$r['username'].' )','userdata'=>$r);
        }

        return Response::json($result);
    }

    public function getUseridbyemail()
    {
        $q = Input::get('term');

        $user = new User();
        $qemail = new MongoRegex('/'.$q.'/i');

        $res = $user->find(array('$or'=>array(array('email'=>$qemail),array('fullname'=>$qemail)) ));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'value'=>$r['_id']->__toString(),'email'=>$r['email'],'label'=>$r['fullname'].' ( '.$r['email'].' )');
        }

        return Response::json($result);
    }

    public function getRev()
    {
        $q = Input::get('term');

        $doc = new Document();
        $qdoc = new MongoRegex('/'.$q.'/i');

        $res = $doc->find(array('title'=>$qdoc),array('title'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['title'],'value'=>$r['_id']->__toString());
        }

        return Response::json($result);
    }

    public function getProject()
    {
        $q = Input::get('term');

        $proj = new Project();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('projectNumber'=>$qproj)) ),array('title','projectNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['projectNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['projectNumber']);
        }

        return Response::json($result);
    }

    public function getProjectname()
    {
        $q = Input::get('term');

        $proj = new Project();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('projectNumber'=>$qproj)) ),array('title','projectNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['projectNumber'].' - '.$r['title'],'number'=>$r['projectNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }


    public function getTender()
    {
        $q = Input::get('term');

        $proj = new Tender();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('tenderNumber'=>$qproj)) ),array('title','tenderNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['tenderNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['tenderNumber']);
        }

        return Response::json($result);
    }

    public function getTendername()
    {
        $q = Input::get('term');

        $proj = new Tender();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('tenderNumber'=>$qproj)) ),array('title','tenderNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['tenderNumber'].' - '.$r['title'],'number'=>$r['tenderNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }

    public function getOpportunity()
    {
        $q = Input::get('term');

        $proj = new Opportunity();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('opportunityNumber'=>$qproj)) ),array('title','opportunityNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['opportunityNumber'].' - '.$r['title'],'title'=>$r['title'],'value'=>$r['opportunityNumber']);
        }

        return Response::json($result);
    }

    public function getOpportunityname()
    {
        $q = Input::get('term');

        $proj = new Opportunity();
        $qproj = new MongoRegex('/'.$q.'/i');

        $res = $proj->find(array('$or'=>array(array('title'=>$qproj),array('opportunityNumber'=>$qproj)) ),array('title','opportunityNumber'));

        $result = array();

        foreach($res as $r){
            $result[] = array('id'=>$r['_id']->__toString(),'label'=>$r['opportunityNumber'].' - '.$r['title'],'number'=>$r['opportunityNumber'],'value'=>$r['title']);
        }

        return Response::json($result);
    }

    public function getMeta()
    {
        $q = Input::get('term');

        $doc = new Document();
        $id = new MongoId($q);

        $res = $doc->get(array('_id'=>$id));

        return Response::json($result);
    }

    public function postParam()
    {
        $in = Input::get();

        $key = $in['key'];
        $value = $in['value'];

        if(setparam($key,$value)){
            return Response::json(array('result'=>'OK'));
        }else{
            return Response::json(array('result'=>'ERR'));
        }

    }

    public function fromCamelCase($camelCaseString) {
            $re = '/(?<=[a-z])(?=[A-Z])/x';
            $a = preg_split($re, $camelCaseString);
            return join($a, " " );
    }

}

