<?php

/**
 * Our homepage. Show the most recently added quote.
 *
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application
{
    protected $all_orders;

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
      $filename = array();


      foreach ($map as $str)
    	{
  		  if (substr_compare($str, $test, strlen($str)-strlen($test), strlen($test)) === 0)
        {
			     if ( $str != 'menu.xml')
			     {
				      $list[] = array('file' => substr($str, 0, -4), 'filename' => $str);
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

      $this->data['filename'] = $filename;
      $this->data['customer'] = $order->getCustomer();
      $this->data['special'] = $order->getSpecial();
      $this->data['order_total'] = $order->getOrderTotal();

      $this->data['file'] = substr($filename, 0, -4);

      $num_burgers = 0;
      $order_total = 0.0;
      $all_orders = array();
      $incoming_orders = $order->getOrder();

      foreach ($incoming_orders as $burger)
      {
          $burgerData = array(
          'order' => $filename,
          'patty' => $burger->patty,
          'toppings' => implode(", ",$burger->topping),
          'sauces' => implode(", ",$burger->sauce)
          );
          $num_burgers++;

          //Check if sauce is empty
          if(empty($burger->sauce))
          {
            $burgerData['sauces'] = "None";
          }
          //Check if topping is empty
          if(empty($burger->topping))
          {
            $burgerData['toppings'] = "None";
          }

          //Only show cheese if there are cheese
          if($burger->cheeseTop != NULL)
          {
            $burgerData['cheeseTop'] = $burger->cheeseTop;
          }
          else
          {
            $burgerData['cheeseTop'] = "";
          }
          if($burger->cheeseBottom != NULL)
          {
            $burgerData['cheeseBottom'] = $burger->cheeseBottom;
          }
          else
          {
            $burgerData['cheeseBottom'] = "";
          }

        //set burger count
        $burgerData['burger_number'] = $num_burgers;
        $burgerData['total'] = $burger->total;
        $order_total += $burger->total;
        //push to orderArray
        array_push($all_orders, $burgerData);

        //var_dump($all_orders);
      }

      // Present the list to choose from
      $this->data['order'] = $all_orders;
      $this->data['pagebody'] = 'justone';
      $this->render();
    }
}

//order object instead of array
//order->customer = blah
//order->
