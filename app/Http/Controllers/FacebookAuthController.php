<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Tymon\JWTAuth\JWTAuth;

class FacebookAuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'access_token' => ['required']
        ];
        $payload = $request->only('access_token');
        $validator = \Illuminate\Support\Facades\Validator::make($payload,$rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'Access token is required'],404);
        }
        $fb = new Facebook([
            'app_id' => '905290879647809',
            'app_secret' => 'f51264b59f17fbcee194452f19cf35ae',
            'default_graph_version' => 'v2.2'
        ]);

        try {
            $response = $fb->get('/me?fields=id,first_name,last_name,email,picture.width(400).height(400),gender', $payload['access_token']);
        } catch (FacebookResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (FacebookSDKException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        $me = $response->getGraphUser();
        $userFacebook = $fb->get("/{$me->getId()}?fields=email", $payload['access_token']);
        
        if ($user = User::query()->where('facebook_id', $me['id'])->first()) {
            Auth::login($user);
            return redirect('/');
        } else {
            $user = User::query()->create([
                'facebook_id' => $me['id'],
                'first_name' => $me['first_name'],
                'last_name' => $me['last_name'],
                'name' => strtolower(trim($me['first_name'] . $me['last_name'])),
                'email' => $userFacebook->getGraphUser()['email'],
            ]);

            $user->photo()->create([
                'source' =>  base64_encode(file_get_contents($me->getProperty('picture')['url'])),
            ]);

            Auth::login($user);
            return redirect('/');
        }
    }
}
