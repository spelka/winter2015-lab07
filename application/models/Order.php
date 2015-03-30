<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model
{

    protected $xml = null;
    protected $customer;
    protected $order;

    // Constructor
    public function __construct($filename = NULL) {
        parent::__construct();
		
		if ( $filename == NULL )
		{
			return;
		}
        $this->xml = simplexml_load_file(DATAPATH . $filename);
		
		$this->customer = (string) $this->xml->customer;
		$this->order = (string) $this->xml['type'];
		
        // for each burger in the XML file, we will parse the data
        foreach ($this->xml->burger as $burger)
		{
            $total = 0;
			$new_burger = new stdClass();
			
			//add the patty to the new burger. Adds NULL if it doesnt exist
			$new_burger->patty = (string) $burger->patty['type'];
			
			//check for a patty
			if ($menu->getPatty($new_burger->patty) != NULL)
			{
				//update the price
				$pattyPrice = $menu->getPatty($new_burger->patty)->price;
				if ( pattyPrice != NULL)
				{
					$total += pattyPrice;
				}
			}
			
			//add the top cheese to the burger. Adds NULL if it does not exist
			$new_burger->cheeseTop = (string) $burger->cheeses['top'];	
			
			//check for a top layer cheese
			var_dump($new_burger);
			if ($menu->getCheese($new_burger->cheeseTop) != NULL)
			{
				//update the price
				$topCheesePrice = (float) $menu->getCheese->($new_burger->cheeseTop)->price;
				if ($topCheesePrice != NULL)
				{
					$total += topCheesePrice;
				}
			}
			
			//add the bottom cheese to the burger
			$new_burger->cheeseBottom = (string) $burger->cheeses['bottom'];
			
			//check for a bottom layer cheese. Adds NULL if it doesnt exist
			if ($menu->getCheese($new_burger->CheeseBottom) != NULL)
			{
				//update the price
				$bottomCheesePrice = $menu->getCheese->($new_burger->CheeseBottom)->price;
				if($bottomCheesePrice != NULL)
				{
					$total += bottomCheesePrice;
				}
			}
			
			//create a new array to hold all the toppings
			$new_burger->topping = array();
			
			//go through all the toppings
			foreach( $burger->topping as $toppings )
			{
				//add the topping to the new burger entry
				array_push( $new_burger->topping, $toppings['type'] );
				
				//update the price
				$toppingPrice = $menu->getTopping((string)$toppings['type'])->price;
				if ( $menu->getTopping((string)$toppings['type']) != NULL )
				{
					$total += toppingPrice;
				}
			}
			
			//create a new array to hold all the sauces
			$new_burger->sauce = array();
			
			foreach ( $burger->sauce as $sauces)
			{
				//add the sauce to the new burger
				array_push($new_burger->sauce, $sauces['type']);
				
				//update the price
				$saucePrice = $menu->getSauce((string)$sauces['type'])->price;
				if ( $menu->getSauce((string)$sauces['type']) != NULL )
				{
					$total += saucePrice;
				}
			}
			
			//assign the running total to the burger
			$burger->total = $total;
			
			//and add the new burger into the order array
			array_push($this->order, $new_burger);
        }
    }
	
	function show_orders()
	{
		$file location = directory_map(DATAPATH);
	}

    // retrieve a list of patties, to populate a dropdown, for instance
    function patties()
	{
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code)
	{
        if (isset($this->patties[$code]))
            return $this->patties[$code];
        else
            return null;
    }

}
