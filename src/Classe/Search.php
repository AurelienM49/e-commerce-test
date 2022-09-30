<?php

namespace App\Classe;

use App\Entity\Category;

class Search
{

	/**
	 * @var string 
	 */
	public $string = '';

	/**
	 * @var Category[]
	 */
	public $categories = [];
	

	/**
	 * @var float
	 */
	public $priceMin;

		/**
	 * @var float
	 */
	public $priceMax;
}
