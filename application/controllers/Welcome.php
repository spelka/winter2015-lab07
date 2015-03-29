<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
	$map = directory_map('./data/', 2);
	$test = '.xml';
	$list = array();
	
	
	
	foreach ($map as $str)
	{
		if (substr_compare($str, $test, strlen($str)-strlen($test), strlen($test)) === 0)
		{
			if ( $str != 'menu.xml')
			{
				$list[] = array('file' => substr($str, 0, -4));
			}
		}
	}
	
	$this->data['orders'] = $list;
	
	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
	$this->load->model('Order');
	$order = new Order($filename);
	
	
	var_dump('Order');
	
	
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
