<?php

namespace App\Validator;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Input;
use Hash;
class CustomeValidator extends Validator
{
	/**
	 * [validatecheckEmailExitForUser To check user email exit or not]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function validatecheckEmailExitForUser($attribute, $value, $parameters)
	{	

		if (isset($parameters[0]) && !empty($parameters[0])) {

            $count = \App\User::where("id", "!=", \Crypt::decrypt($parameters[0]))
                ->where("email", $value)
                ->count();

        } else {

            $count = \App\User::where("email", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
	}

	
	
}
?>