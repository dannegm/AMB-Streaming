<?php

class CervantinoController extends BaseController{

	public function index(){
		return View::make('cervantino/index');
	}

	public function entrar(){

		$username = Input::get('username');
		$password = Input::get('password');

		echo "HolaMundo";

}