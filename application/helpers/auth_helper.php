<?php

if( ! function_exists('get_auth_array'))
{
	function get_auth_array()
	{
		return array(
			'255' => 'Administrator',
			'1' => 'User'
		);
	}
}

if(function_exists('get_auth'))
{
	function get_auth($id)
	{
		$array_auth = get_auth_array();
		if(array_key_exists($id, $array_auth))
		{
			
			return $array_auth[$id];
		}
		else
		{
			return NULL;
		}
	}
}