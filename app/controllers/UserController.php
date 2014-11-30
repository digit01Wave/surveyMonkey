<?php

class UserController extends BaseController
{
	//gets the view for the register page
	public function getCreate()
	{
		return View::make('user.register');

	}

	//gets the view for the login page
	public function getLogin()
	{
		return View::make('user.login');
	}

	//handles register form data
	public function postCreate()
	{
		//gets all input and array is rules for all the stuff you want to validate
		$validate = Validator::make(Input::all(), array(
			'username' => 'required|unique:users|min:4',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1'
		));

		if ($validate->fails())
		{
			return Redirect::route('getCreate')->withErrors($validate)->withInput();
		}
		else
		{

			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('pass1'));
			if($user->save()) //if created successfully
			{
				return Redirect::route('home')->with('success','You registered successfully. You can now log in.');
			}
			else
			{
				return Redirect::route('home')->with('fail','An error occured. Please try again.');
			}
		}
	}

	//handles login form data
	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'username' => 'required',
			'pass1' => 'required'
		));

		if($validator->fails())
		{
			return Redirect::route('getLogin')->withErrors($validator)->withInput();
		}
		else
		{
			//if there is input of remember, $remember is true
			$remember = (Input::has('remember')) ? true:false;
			$auth = Auth::attempt(array(
				'username'=>Input::get('username'),
				'password'=>Input::get('pass1')
			), $remember);

			if($auth)
			{
				return Redirect::intended('/');
				//return Redirect::route('survey-home');
			}
			else
			{
				return Redirect::route('getLogin')->with('fail', 'You entered the wrong login credentials. Please try again.');
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}
}
?>
