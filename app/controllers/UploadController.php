<?php

class UploadController extends Controller {

    public function __construct()
    {

    }

    public function postIndex()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $large_wm = public_path().'/wm/wm_lrg.png';
        $med_wm = public_path().'/wm/wm_med.png';
        $sm_wm = public_path().'/wm/wm_sm.png';

        $rstring = str_random(15);

        $destinationPath = realpath('storage/media').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);


        $is_image = $this->isImage($filemime);
        $is_audio = $this->isAudio($filemime);
        $is_video = $this->isVideo($filemime);
        $is_pdf = $this->isPdf($filemime);

        if(!($is_image || $is_audio || $is_video || $is_pdf)){
            $is_doc = true;
        }else{
            $is_doc = false;
        }

        if($is_image){

            $ps = Config::get('picture.sizes');

            if($ps['thumbnail']['width'] == $ps['thumbnail']['height']){
                $sqcanvas = Image::canvas(($ps['thumbnail']['width'] + 10) ,($ps['thumbnail']['height'] + 10) , '#FFFFFF');


                $thsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['thumbnail']['width'],$ps['thumbnail']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $thumbnail = $sqcanvas->insert($thsrc, 'center')
                    ->save($destinationPath.'/th_'.$filename);

            }else{
                $thumbnail = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['thumbnail']['width'],$ps['thumbnail']['height'])
                    //->insert($sm_wm,0,0, 'bottom-right')
                    ->save($destinationPath.'/th_'.$filename);

            }

            if($ps['medium']['width'] == $ps['medium']['height']){

                $sqcanvas = Image::canvas(($ps['medium']['width'] + 10) ,($ps['medium']['height'] + 10) , '#FFFFFF');


                $medsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['medium']['width'],$ps['medium']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $medium = $sqcanvas->insert($medsrc, 'center')
                    ->save($destinationPath.'/med_'.$filename);

            }else{
                $medium = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['medium']['width'],$ps['medium']['height'])
                    ->save($destinationPath.'/med_'.$filename);

            }


            if($ps['medium_portrait']['width'] == $ps['medium_portrait']['height']){

                $sqcanvas = Image::canvas(($ps['medium_portrait']['width'] + 10) ,($ps['medium_portrait']['height'] + 10) , '#FFFFFF');


                $medsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['medium_portrait']['width'],$ps['medium_portrait']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $medium_portrait = $sqcanvas->insert($medsrc, 'center')
                    ->save($destinationPath.'/med_port_'.$filename);

            }else{
                $medium_portrait = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['medium_portrait']['width'],$ps['medium_portrait']['height'])
                    ->save($destinationPath.'/med_port_'.$filename);

            }

            if($ps['large']['width'] == $ps['large']['height']){

                $sqcanvas = Image::canvas(($ps['large']['width'] + 10) ,($ps['large']['height'] + 10) , '#FFFFFF');


                $lrgsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['large']['width'],$ps['large']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $large = $sqcanvas->insert($lrgsrc, 'center')
                    ->save($destinationPath.'/med_'.$filename);

            }else{
                $large = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['large']['width'],$ps['large']['height'])
                    //->insert($large_wm, 'bottom-right',15,15)
                    ->save($destinationPath.'/lrg_'.$filename);
            }


            $full = Image::make($destinationPath.'/'.$filename)
                ->insert($large_wm, 'bottom-right',15,15)
                ->save($destinationPath.'/full_'.$filename);

            $image_size_array = array(
                'thumbnail_url'=> URL::to('storage/media/'.$rstring.'/'.$ps['thumbnail']['prefix'].$filename),
                'large_url'=> URL::to('storage/media/'.$rstring.'/'.$ps['large']['prefix'].$filename),
                'medium_url'=> URL::to('storage/media/'.$rstring.'/'.$ps['medium']['prefix'].$filename),
                'full_url'=> URL::to('storage/media/'.$rstring.'/'.$ps['full']['prefix'].$filename),
            );

        }else{

            if($is_audio){
                $thumbnail_url = URL::to('images/audio.png');
            }elseif($is_video){
                $thumbnail_url = URL::to('images/video.png');
            }else{
                $thumbnail_url = URL::to('images/media.png');
            }

            $image_size_array = array(
                'thumbnail_url'=> $thumbnail_url,
                'large_url'=> '',
                'medium_url'=> '',
                'full_url'=> ''
            );
        }


        $fileitems = array();

        if($uploadSuccess){
            $item = array(
                    'url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'temp_dir'=> $destinationPath,
                    'file_id'=> $rstring,
                    'is_image'=>$is_image,
                    'is_audio'=>$is_audio,
                    'is_video'=>$is_video,
                    'is_pdf'=>$is_pdf,
                    'is_doc'=>$is_doc,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'delete_type'=> 'DELETE'
                );

            foreach($image_size_array as $k=>$v){
                $item[$k] = $v;
            }

            $fileitems[] = $item;

        }

        return Response::JSON(array('status'=>'OK','message'=>'' ,'files'=>$fileitems) );
    }

    public function postSlide()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $large_wm = public_path().'/wm/wm_lrg.png';
        $med_wm = public_path().'/wm/wm_med.png';
        $sm_wm = public_path().'/wm/wm_sm.png';

        $rstring = str_random(15);

        $destinationPath = realpath('storage/media').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        $ps = Config::get('picture.sizes');

        $thumbnail = Image::make($destinationPath.'/'.$filename)
            ->fit($ps['thumbnail']['width'],$ps['thumbnail']['height'])
            //->insert($sm_wm,0,0, 'bottom-right')
            ->save($destinationPath.'/th_'.$filename);

        $medium = Image::make($destinationPath.'/'.$filename)
            ->fit($ps['medium']['width'],$ps['medium']['height'])
            //->insert($med_wm,0,0, 'bottom-right')
            ->save($destinationPath.'/med_'.$filename);

        $large = Image::make($destinationPath.'/'.$filename)
            ->fit($ps['large']['width'],$ps['large']['height'])
            //->insert($large_wm, 'bottom-right',15,15)
            ->save($destinationPath.'/lrg_'.$filename);

        $full = Image::make($destinationPath.'/'.$filename)
            //->insert($large_wm, 'bottom-right',15,15)
            ->save($destinationPath.'/full_'.$filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('storage/media/'.$rstring.'/th_'.$filename),
                    'large_url'=> URL::to('storage/media/'.$rstring.'/lrg_'.$filename),
                    'medium_url'=> URL::to('storage/media/'.$rstring.'/med_'.$filename),
                    'full_url'=> URL::to('storage/media/'.$rstring.'/full_'.$filename),
                    'temp_dir'=> $destinationPath,
                    'file_id'=> $rstring,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }

    public function postAvatar($ns = 'photo')
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $large_wm = public_path().'/wm/wm_lrg.png';
        $med_wm = public_path().'/wm/wm_med.png';
        $sm_wm = public_path().'/wm/wm_sm.png';

        $rstring = str_random(15);

        $destinationPath = realpath('storage/avatar').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);


        $is_image = $this->isImage($filemime);
        $is_audio = $this->isAudio($filemime);
        $is_video = $this->isVideo($filemime);
        $is_pdf = $this->isPdf($filemime);

        if(!($is_image || $is_audio || $is_video || $is_pdf)){
            $is_doc = true;
        }else{
            $is_doc = false;
        }

        if($is_image){

            $ps = Config::get('picture.sizes');

            if($ps['thumbnail']['width'] == $ps['thumbnail']['height']){
                $sqcanvas = Image::canvas(($ps['thumbnail']['width'] + 10) ,($ps['thumbnail']['height'] + 10) , '#FFFFFF');


                $thsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['thumbnail']['width'],$ps['thumbnail']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $thumbnail = $sqcanvas->insert($thsrc, 'center')
                    ->save($destinationPath.'/th_'.$filename);

            }else{
                $thumbnail = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['thumbnail']['width'],$ps['thumbnail']['height'])
                    //->insert($sm_wm,0,0, 'bottom-right')
                    ->save($destinationPath.'/th_'.$filename);

            }

            if($ps['medium']['width'] == $ps['medium']['height']){

                $sqcanvas = Image::canvas(($ps['medium']['width'] + 10) ,($ps['medium']['height'] + 10) , '#FFFFFF');


                $medsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['medium']['width'],$ps['medium']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $medium = $sqcanvas->insert($medsrc, 'center')
                    ->save($destinationPath.'/med_'.$filename);

            }else{
                $medium = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['medium']['width'],$ps['medium']['height'])
                    ->save($destinationPath.'/med_'.$filename);

            }


            if($ps['large']['width'] == $ps['large']['height']){

                $sqcanvas = Image::canvas(($ps['large']['width'] + 10) ,($ps['large']['height'] + 10) , '#FFFFFF');


                $lrgsrc = Image::make($destinationPath.'/'.$filename)
                    ->resize($ps['large']['width'],$ps['large']['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    });

                $large = $sqcanvas->insert($lrgsrc, 'center')
                    ->save($destinationPath.'/med_'.$filename);

            }else{
                $large = Image::make($destinationPath.'/'.$filename)
                    ->fit($ps['large']['width'],$ps['large']['height'])
                    //->insert($large_wm, 'bottom-right',15,15)
                    ->save($destinationPath.'/lrg_'.$filename);
            }


            $full = Image::make($destinationPath.'/'.$filename)
                ->insert($large_wm, 'bottom-right',15,15)
                ->save($destinationPath.'/full_'.$filename);

            $image_size_array = array(
                'thumbnail_url'=> URL::to('storage/avatar/'.$rstring.'/'.$ps['thumbnail']['prefix'].$filename),
                'large_url'=> URL::to('storage/avatar/'.$rstring.'/'.$ps['large']['prefix'].$filename),
                'medium_url'=> URL::to('storage/avatar/'.$rstring.'/'.$ps['medium']['prefix'].$filename),
                'full_url'=> URL::to('storage/avatar/'.$rstring.'/'.$ps['full']['prefix'].$filename),
            );

            $status = 'OK';
            $message = '';
        }else{
            $file_url = URL::to('storage/avatar/'.$rstring.'/'.$filename);
            if($is_audio){
                $thumbnail_url = View::make('media.audio')->with('title',$filename)->with('artist','-')->with('source',$file_url);
            }elseif($is_video){
                $thumbnail_url = URL::to('images/video.png');
            }else{
                $thumbnail_url = URL::to('images/media.png');
            }

            $image_size_array = array(
                'thumbnail_url'=> $thumbnail_url,
                'large_url'=> '',
                'medium_url'=> '',
                'full_url'=> ''
            );

            $status = 'ERR';
            $message = 'Please upload picture file for avatar';
        }


        $fileitems = array();

        if($uploadSuccess){
            $item = array(
                    'ns'=>$ns,
                    'role'=>'photo',
                    'url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'temp_dir'=> $destinationPath,
                    'file_id'=> $rstring,
                    'is_image'=>$is_image,
                    'is_audio'=>$is_audio,
                    'is_video'=>$is_video,
                    'is_pdf'=>$is_pdf,
                    'is_doc'=>$is_doc,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'delete_type'=> 'DELETE'
                );

            foreach($image_size_array as $k=>$v){
                $item[$k] = $v;
            }

            $fileitems[] = $item;

        }

        return Response::JSON(array('status'=>$status,'role'=>'photo' ,'message'=>$message ,'files'=>$fileitems) );
    }

    public function postProduct()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $large_wm = public_path().'/wm/wm_lrg.png';
        $med_wm = public_path().'/wm/wm_med.png';
        $sm_wm = public_path().'/wm/wm_sm.png';

        $rstring = str_random(15);

        $destinationPath = realpath('storage/media/product').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        $thumbnail = Image::make($destinationPath.'/'.$filename)
            ->fit(100,74)
            //->insert($sm_wm,0,0, 'bottom-right')
            ->save($destinationPath.'/th_'.$filename);

        $medium = Image::make($destinationPath.'/'.$filename)
            ->fit(270,200)
            //->insert($med_wm,0,0, 'bottom-right')
            ->save($destinationPath.'/med_'.$filename);

        $large = Image::make($destinationPath.'/'.$filename)
            ->fit(870,420)
            //->insert($large_wm,15,15, 'bottom-right')
            ->save($destinationPath.'/lrg_'.$filename);

        $full = Image::make($destinationPath.'/'.$filename)
            //->insert($large_wm,15,15, 'bottom-right')
            ->save($destinationPath.'/full_'.$filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('storage/media/product/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('storage/media/product/'.$rstring.'/th_'.$filename),
                    'large_url'=> URL::to('storage/media/product/'.$rstring.'/lrg_'.$filename),
                    'medium_url'=> URL::to('storage/media/product/'.$rstring.'/med_'.$filename),
                    'full_url'=> URL::to('storage/media/product/'.$rstring.'/full_'.$filename),
                    'temp_dir'=> $destinationPath,
                    'file_id'=> $rstring,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }

    public function postMusic()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $rstring = str_random(15);

        $destinationPath = realpath('storage/media').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        /*
        $thumbnail = Image::make($destinationPath.'/'.$filename)
            ->fit(100,100)
            ->save($destinationPath.'/th_'.$filename);
        */

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('storage/media/th_music.jpg'),
                    'temp_dir'=> $destinationPath,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> URL::to('storage/media/'.$rstring.'/'.$filename),
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }


    public function postAdd()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $rstring = str_random(8);

        $destinationPath = realpath('storage/temp').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        $thumbnail = Image::make($destinationPath.'/'.$filename)
            ->fit(320,240)
            ->save($destinationPath.'/th_'.$filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('storage/temp/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('storage/temp/'.$rstring.'/th_'.$filename),
                    'temp_dir'=> $destinationPath,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> 'http://url.to/delete /file/',
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }


    public function postEdit()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $rstring = str_random(8);

        $destinationPath = realpath('storage/temp').'/'.$rstring;

        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $filename = str_replace(Config::get('kickstart.invalidchars'), '-', $filename);

        $uploadSuccess = $file->move($destinationPath, $filename);

        $thumbnail = Image::make($destinationPath.'/'.$filename)
            ->fit(320,240)
            ->save($destinationPath.'/th_'.$filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('storage/temp/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('storage/temp/'.$rstring.'/th_'.$filename),
                    'temp_dir'=> $destinationPath,
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> 'http://url.to/delete /file/',
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }

    public function postDelete($file_id)
    {


    }

    public function postUp(){

        $file = Input::file('file');

        $destinationPath = Config::get('kickstart.storage').'/uploads/'.str_random(8);
        $filename = $file->getClientOriginalName();
        //$extension =$file->getClientOriginalExtension();
        $upload_success = Input::file('file')->move($destinationPath, $filename);

        if( $upload_success ) {
           return Response::json('success', 200);
        } else {
           return Response::json('error', 400);
        }

    }

    private function isAudio($mime){
        return preg_match('/^audio/',$mime);
    }

    private function isVideo($mime){
        return preg_match('/^video/',$mime);
    }

    private function isImage($mime){
        return preg_match('/^image/',$mime);
    }

    private function isPdf($mime){
        return preg_match('/pdf/',$mime);
    }



}
