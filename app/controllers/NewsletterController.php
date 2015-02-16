<?php

class NewsletterController extends AdminController {

    public function __construct()
    {
        parent::__construct();

        $this->controller_name = str_replace('Controller', '', get_class());

        //$this->crumb = new Breadcrumb();
        //$this->crumb->append('Home','left',true);
        //$this->crumb->append(strtolower($this->controller_name));

        $this->model = new Template();
        //$this->model = DB::collection('documents');
        $this->title = $this->controller_name;

    }

    public function getTest()
    {
        $raw = $this->model->where('docFormat','like','picture')->get();

        print $raw->toJSON();
    }


    public function getIndex()
    {

        $categories = Prefs::getCategory()->catToSelection('title','title');

        $this->heads = array(
            array('Title',array('search'=>true,'sort'=>true)),
            array('Status',array('search'=>true,'sort'=>true)),
            array('Creator',array('search'=>true,'sort'=>false)),
            array('Category',array('search'=>true,'select'=>$categories,'sort'=>true)),
            array('Tags',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        //print $this->model->where('docFormat','picture')->get()->toJSON();

        return parent::getIndex();

    }

    public function postIndex()
    {

        $this->additional_query = array('type'=>'newsletter');

        $this->fields = array(
            array('title',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('status',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('creatorName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('category',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('tags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'callback'=>'splitTag')),
            array('createdDate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'datetime','query'=>'like','pos'=>'both','show'=>true)),
        );

        return parent::postIndex();
    }

    public function postAdd($data = null)
    {

        $this->validator = array(
            'title' => 'required',
            'slug'=> 'required'
        );

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {
        $this->validator = array(
            'title' => 'required',
            'slug'=> 'required'
        );

        return parent::postEdit($id,$data);
    }

    public function beforeSave($data)
    {
        $data['creatorName'] = Auth::user()->fullname;
        $data['type'] = 'newsletter';

        $data['status'] = 'inactive';

        $template = Str::random(8);

        if(file_put_contents(public_path().'/themes/default/views/newslettertmpl/'.$template.'.blade.php', $data['body'])){
            $data['template'] = $template;
        }

        return $data;
    }

    public function beforeUpdate($id,$data)
    {
        $template = ($data['template'] == '')?Str::random(8):$data['template'];

        file_put_contents(public_path().'/themes/default/views/newslettertmpl/'.$template.'.blade.php', $data['body']);

        return $data;
    }


    public function getPreview($template,$type = null)
    {
        $prop = Property::where('brchead','exists', true)->where('brchead','!=', '')->first()->toArray();

        //print_r($prop);

        //die();

        //return View::make('print.brochure')->with('prop',$prop)->render();

        if(!is_null($type) && $type != 'pdf'){
            $content = View::make('brochuretmpl.'.$template)->with('prop',$prop)->render();
            return $content;
        }else{
            //return PDF::loadView('print.brochure',array('prop'=>$prop))
            //    ->stream('download.pdf');

            return PDF::loadView('brochuretmpl.'.$template, array('prop'=>$prop))
                        ->setOption('margin-top', '0mm')
                        ->setOption('margin-left', '0mm')
                        ->setOption('margin-right', '0mm')
                        ->setOption('margin-bottom', '0mm')
                        ->setOption('dpi',200)
                        ->setPaper('A4')
                        ->stream($prop['propertyId'].'.pdf');

            //return PDF::html('print.brochure',array('prop' => $prop), 'download.pdf');
        }

    }

    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="fa fa-trash"></i>Delete</span>';
        $active = '<span class="active" id="'.$data['_id'].'" ><i class="fa fa-trash"></i>Set Active</span>';
        $edit = '<a href="'.URL::to('newsletter/edit/'.$data['_id']).'"><i class="fa fa-edit"></i>Update</a>';

        $pdf = '<a href="'.URL::to('newsletter/preview/'.$data['template'].'/pdf').'" target="blank"
        ><i class="fa fa-edit"></i>PDF Preview</a>';
        $html = '<a href="'.URL::to('newsletter/preview/'.$data['template'].'/html').'" target="blank"
        ><i class="fa fa-edit"></i>HTML Preview</a>';

        $actions = $edit.'<br />'.$active.'<br />'.$delete.'<br />'.$pdf.'<br />'.$html;
        return $actions;
    }

    public function splitTag($data){
        $tags = explode(',',$data['tags']);
        if(is_array($tags) && count($tags) > 0 && $data['tags'] != ''){
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
        $name = HTML::link('products/view/'.$data['_id'],$data['productName']);
        if(isset($data['thumbnail_url']) && count($data['thumbnail_url'])){
            $display = HTML::image($data['thumbnail_url'][0].'?'.time(), $data['filename'][0], array('id' => $data['_id']));
            return $display.'<br />'.$name;
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
