<?php

class PhpTestController extends Controller
{
	public function actionIndex()
	{
		//$this->render('index');
            $url = "http://google.com";
            $html = file_get_contents($url);
            echo $html;
	}
}