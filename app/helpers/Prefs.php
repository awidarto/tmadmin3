<?php

class Prefs {

    public static $category;

    public function __construct()
    {

    }

    public static function getCategory(){
        $c = Category::get();

        self::$category = $c;
        return new self;
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

    public function catToArray(){
        return self::$category;
    }
}
