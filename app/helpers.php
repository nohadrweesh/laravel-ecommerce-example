<?php
     function presentPrice($price)
    {
        //return money_format('$%i', $this->price / 100);
        return '$'.number_format($price / 100, 2);
    }

    function setActiveCategory($category,$output="active"){
    	return request()->category==$category?$output: '';

    }