<?php
namespace Api;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;

class AuthController extends \Controller {
	public function  __construct()
	{
		//$this->model = "Member";
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		echo "Hello world!";
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	 * @name login()
	 * @param string user
	 * @param sring pwd
	 * @method POST
	 */

    public function login(){

    	if(Input::has('user') && Input::has('pwd'))
    	{
    		$retVal = array("status" => "ERR", "msg" => "Invalid username or password.");
    		try {
    			$user = \User::where('email', '=', Input::get('user'))->firstorFail();
    			if($user)
    			{
    				if(Hash::check(Input::get('pwd'), $user->password))
    				{
    					$sessionKey = md5(time() . $user->email . $user->_id . "momumu<-Salt?");

    					$user->sessionKey = $sessionKey;
    					$user->save();

                        $userarray = $user->toArray();
                        $userarray['createdDate'] = date('Y-m-d H:i:s',$userarray['createdDate']->sec);
                        $userarray['lastUpdate'] = date('Y-m-d H:i:s',$userarray['lastUpdate']->sec);
                        $userarray['mongoid'] = $userarray['_id'];
                        unset($userarray['password']);
                        unset($userarray['_id']);
                        unset($userarray['_token']);
                        unset($userarray['session_key']);


                        $retVal = array_merge(array("status" => "OK", "msg" => "Login Success.", "key" => $sessionKey), $userarray) ;

    				}
    			}

    		}
    		catch (ModelNotFoundException $e){

    		}

    		return Response::json($retVal);
    	}

    }

    /**
     * @name logout()
     * @param string session_key
     * @method POST
     */

    public function logout(){

    	if(Input::has('session_key'))
    	{
    		$retVal = array("status" => "ERR", "msg" => "Invalid session.");
    		try {
	    		$user = \User::where('session_key', '=', Input::get('session_key'))->firstorFail();
	    		if($user)
	    		{
	    				$retVal = array("status" => "OK");
	    				$user->session_key = null;
	    				$user->save();
	    		}
    		}
    		catch (ModelNotFoundException $e)
    		{

    		}
    		return Response::json($retVal);
    	}

    }

    public function missingMethod($parameters = array())
    {
        //
    }

}
