<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiCommanFunctionController as ApiCommanFunctionController;
use Validator;
use App\User;
use Auth;

class ApiFunctionCallController extends ApiCommanFunctionController
{

    public function ApiUserregistration(Request $r){

        $input = $r->all();
        $rules = [
            'name'     => 'required',
            'email'     => 'required|email|checkEmailExitForUser',
            'password'     => 'required',
        ];
        $message = [

            'name.required'    => "Name field is required.",
            'email.required'    => "Email field is required",
            'email.check_email_exit_for_user'    => "Email alredy exits.",
            'password.required'    => "Password field is required",
        ];

        $validator = Validator::make($input,$rules,$message);


        if ($validator->fails()) {

            return app('App\Http\Controllers\Api\ApiCommanFunctionController')->sendError($validator->errors()->first(), $errorMessages = [], $code = 422);
        }


        $obj = new User;
        $obj->name  =$r->name;
        $obj->email  =$r->email;
        $obj->password  =\Hash::make($r->password);
        $obj->save();

        if ($obj !=null) {
            
            return response()->json(['status' => 200,'msg'=>"User successfully register.",'data' => $obj ]);exit;

        }else{

            return response()->json(['status' => 204,'msg'=>"Somethinig is wrong or data not found",'data' => (object)[] ]);exit;
        }  
    
    }
     /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $input = $request->all();
        $rules = [
            'email'     => 'required|email',
            'password'     => 'required',
        ];
        $message = [

            'email.required'    => "Email field is required",
            'password.required'    => "Password field is required",
        ];

        $validator = Validator::make($input,$rules,$message);

        if ($validator->fails()) {

            return app('App\Http\Controllers\Api\ApiCommanFunctionController')->sendError($validator->errors()->first(), $errorMessages = [], $code = 422);
        }

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['status' => 404,'msg'=>"Invalid credentials",'data' => (object)[] ]);exit;
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}