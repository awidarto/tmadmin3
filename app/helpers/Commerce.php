<?php

class Commerce{

    public static function updateStock($data, $positive = 'available', $negative = 'deleted')
    {

        //print_r($data);

        $outlets = $data['outlets'];
        $outletNames = $data['outletNames'];
        $addQty = $data['addQty'];
        $adjustQty = $data['adjustQty'];

        unset($data['outlets']);
        unset($data['outletNames']);
        unset($data['addQty']);
        unset($data['adjustQty']);

        $productDetail = Product::find($data['id'])->toArray();

        // year and month used fro batchnumber
        $year = date('Y', time());
        $month = date('m',time());


        for( $i = 0; $i < count($outlets); $i++)
        {

            $su = array(
                    'outletId'=>$outlets[$i],
                    'outletName'=>$outletNames[$i],
                    'productId'=>$data['id'],
                    'SKU'=>$data['SKU'],
                    'productDetail'=>$productDetail,
                    'status'=>$positive,
                    'createdDate'=>new MongoDate(),
                    'lastUpdate'=>new MongoDate()
                );

            if($addQty[$i] > 0){
                for($a = 0; $a < $addQty[$i]; $a++){
                    $su['_id'] = str_random(8);


                    $batchnumber = Prefs::GetBatchId($data['SKU'], $year, $month);

                    $su['_id'] = $data['SKU'].'|'.$batchnumber;

                    $history = array(
                        'datetime'=>new MongoDate(),
                        'action'=>'init',
                        'price'=>$productDetail['priceRegular'],
                        'status'=>$su['status'],
                        'outletName'=>$su['outletName']
                    );

                    $su['history'] = array($history);

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
                    $d->status = $negative;
                    $d->lastUpdate = new MongoDate();
                    $d->save();

                    $history = array(
                        'datetime'=>new MongoDate(),
                        'action'=>'delete',
                        'price'=>$d->priceRegular,
                        'status'=>$d->status,
                        'outletName'=>$d->outletName
                    );

                    $d->push('history', $history);
                }
            }

        }
    }

    public static function updatePrice($data)
    {
        if(isset($data['disc_outlets'])){


            $outlets = $data['disc_outlets'];
            $from = $data['tFrom'];
            $until = $data['tUntil'];
            $reg_price = $data['tReg'];
            $discs = $data['tDisc'];


            for($i = 0; $i < count($outlets);$i++){
                $disc = new Discount();

                $disc->productId = $data['id'];
                $disc->outletId = $outlets[$i];
                $disc->from = $from[$i];
                $disc->until = $until[$i];
                $disc->regPrice = $reg_price[$i];
                $disc->discount = $discs[$i];
                $disc->createdDate = new MongoDate();

                $disc->save();
            }

        }

    }

    public static function getPrice($productId, $outletId, $defaultprice)
    {
        $productId = new MongoId($productId);
        $l = Discount::where('productId', $productId)
                ->where('outletId', $outletId )->orderBy('createdDate','desc')->first();

        if($l){
            if($l->regPrice != 0 && $l->regPrice != ''){
                return doubleval($l->regPrice);
            }else{
                return $defaultprice;
            }
        }else{
            return $defaultprice;
        }
    }

    public static function getDiscountPrice($productId, $outletId, $defaultprice)
    {
        $productId = new MongoId($productId);
        $l = Discount::where('productId', $productId)
                ->where('outletId', $outletId )->orderBy('createdDate','desc')->first();

        if($l){
            if($l->discount != '' && $l->discount != 0){
                if( doubleval($l->discount) <= 100){
                    return doubleval($l->regPrice) * ( doubleval($l->discount)/ 100);
                }else{
                    if($l->regPrice != 0 && $l->regPrice != ''){
                        return doubleval($l->regPrice);
                    }else{
                        return $defaultprice;
                    }
                }
            }else{
                if($l->regPrice != 0 && $l->regPrice != ''){
                    return doubleval($l->regPrice);
                }else{
                    return $defaultprice;
                }
            }
        }else{
            return $defaultprice;
        }
    }

    public static function getLatestPrice($productId)
    {
        $productId = new MongoId($productId);

        $outlets = Outlet::get();

        $latest = array();
        foreach($outlets as $o){
            $l = Discount::where('productId', $productId)
                    ->where('outletId', $o->_id )->orderBy('createdDate','desc')->first();
            //$l = $l->toArray();
            if($l){
                $out = $l->outletId;
                $latest[$out]['tFrom'] = $l->from;
                $latest[$out]['tUntil'] = $l->until;
                $latest[$out]['tReg'] = $l->regPrice;
                $latest[$out]['tDisc'] = $l->discount;
            }else{
                $out = $o->_id;
                $latest[$out]['tFrom'] = '';
                $latest[$out]['tUntil'] = '';
                $latest[$out]['tReg'] = '';
                $latest[$out]['tDisc'] = '';
            }

        }

        //print_r($latest);

        return $latest;
    }

}