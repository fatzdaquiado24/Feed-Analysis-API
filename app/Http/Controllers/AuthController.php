<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Notifications\AccountVerification;
use Hash;
use DB;
use Cloudinary\Uploader;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'cellphone_number' => 'required|digits:12|starts_with:63',
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    if(Client::where('email', $value)->where('status', 'Approved')->count() > 0) {
                        $fail('The email has already been taken.');
                    }
                }
            ],
            'password' => 'required|string|min:8|confirmed',
            'client_type' => 'required|string|in:Student,Farm Owner,Business Owner',
            'valid_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'business_permit' => 'required_if:client_type,Business Owner|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $valid_id = Uploader::upload($request->valid_id);
        if($request->business_permit) $business_permit = Uploader::upload($request->business_permit);

        $client = Client::where('email', $request->email)->first();
        if(!$client) {
            $client = new Client([
                'name' => $request->name,
                'address' => $request->address,
                'cellphone_number' => $request->cellphone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'activation_token' => str_random(60),
                'client_type' => $request->client_type,
                'valid_id' => $valid_id["secure_url"],
                'business_permit' => $request->business_permit ? $business_permit["secure_url"] : null
            ]);
        } else {
            $validIdImageId = explode(".", basename($client->valid_id))[0];
            Uploader::destroy($validIdImageId);
            if($client->business_permit != null) {
                $businessPermitImageId = explode(".", basename($client->business_permit))[0];
                Uploader::destroy($businessPermitImageId);
            }

            $client->name = $request->name;
            $client->address = $request->address;
            $client->cellphone_number = $request->cellphone_number;
            $client->email = $request->email;
            $client->password = Hash::make($request->password);
            $client->activation_token = str_random(60);
            $client->client_type = $request->client_type;
            $client->valid_id = $valid_id["secure_url"];
            $client->business_permit = $request->business_permit ? $business_permit["secure_url"] : null;
        }
        
        DB::beginTransaction();
        try {
            $client->save();
            $client->notify(new AccountVerification());

            DB::commit();
            return response()->json(['message' => 'Please confirm your account by email to continue']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function verify($token)
    {
        $client = Client::where('activation_token', $token)->first();
        if(!$client) {
            if(!request()->expectsJson()) {
                return view('verify', [
                    'status' => 'Error',
                    'message' => 'This activation token is invalid or has expired'
                ]);
            }
            return response()->json(['message' => 'This activation token is invalid or has expired'], 404);
        }

        $client->status = 'For approval';
        $client->activation_token = null;

        if($client->save()) {
            if(!request()->expectsJson()) {
                return view('verify', [
                    'status' => 'Success',
                    'message' => 'Account confirmation successful. Please wait for your account approval'
                ]);
            }
            return response()->json(['message' => 'Account confirmation successful. Please wait for your account approval']);
        }
        return response()->json(['message' => 'An Error Has Occurred'], 500);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:client,head manager,chemist,receiver,certificate releaser'
        ]);

        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(env('PASSPORT_LOGIN_ENDPOINT'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'provider' => $request->type
                ]
            ]);

            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json(['message' => 'Invalid Request. Please enter a username and password'], $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json(['message' => 'Your credentials are incorrect. Please try again'], $e->getCode());
            }
            
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logout successful']);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}