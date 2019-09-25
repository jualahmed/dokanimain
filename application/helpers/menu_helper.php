<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('active_link_controller'))
{
  function active_link_controller($controller)
  {
    $CI    =& get_instance();
    $class = $CI->router->fetch_class();

    
    return ($class == $controller) ? 'active' : NULL;
    
  }
}

if ( ! function_exists('active_link_function'))
{
  function active_link_function($controller,$method)
  {
    $CI    =& get_instance();
    $class = $CI->router->fetch_class();
    $methods = $CI->router->fetch_method();
    if($class == $controller){
      return ($methods == $method) ? 'active' : NULL;
    }
  }
}