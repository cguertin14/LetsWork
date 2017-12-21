<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class FacebookAuthController extends Controller
{
    /**
     * @param Request $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request,JWTAuth $JWTAuth)
    {
        $fb = new Facebook([
            'app_id' => '905290879647809',
            'app_secret' => 'f51264b59f17fbcee194452f19cf35ae',
            'default_graph_version' => 'v2.2'
        ]);

        // Get Javascript helper
        $helper = $fb->getJavaScriptHelper();
        //return 'allo';

        try {
            // Get access token
            $accessToken = (string) $helper->getAccessToken()->getValue();
            $response = $fb->get('/me?fields=id,first_name,last_name,email,birthday,picture.width(400).height(400),gender', $accessToken);
        } catch (FacebookResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (FacebookSDKException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        $me = $response->getGraphUser();
        if ($user = User::query()->where('facebook_id', $me['id'])->first()) {
            //$token = $JWTAuth->fromUser($user);
            return response()->json(['url' => '/']);
        } else {
            $photo = Photo::query()->create([
                'image' => $me->getProperty('picture')['url'],
            ]);

            $user = User::query()->create([
                'facebook_id' => $me['id'],
                'first_name' => $me['first_name'],
                'last_name' => $me['last_name'],
                'name' => strtolower(trim($me['first_name'] . $me['last_name'])),
                'email' => $me['email'],
                'photo_id' => $photo->id,
            ]);

            $token = $JWTAuth->fromUser($user);
            return response()->json(['url' => '/']);
        }
    }
}
