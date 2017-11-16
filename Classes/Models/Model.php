<?php 
	namespace Locadora\Models;

	abstract class Model{
		protected $container;
		public function __construct(\Slim\Container $container){
			$this->container = $container;
		}
		public function __get($key){
			if($this->container->{$key}){
				return $this->container->{$key};
			}
		}
	}

 ?>