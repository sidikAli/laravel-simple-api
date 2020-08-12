<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(Request $request){

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)){
            $user = Auth::user();
            $user['api_token'] =  $user->createToken('nApp')->accessToken;
            return response()->json($user, $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        
    }

    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3',
            'c_password' => 'required|same:password',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 401);            
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $success['name'] =  $user->name;
        $success['token'] =  $user->createToken('nApp')->accessToken;

        return response()->json($success, $this->successStatus);
    }
}