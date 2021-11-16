<?php

namespace App\Http\Controllers;

use App\User;
use Guzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    public function getToken(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => env('OSU_API_CLIENT_ID'),
            'redirect_uri' => route('oauth-callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);
        return redirect(config('app.osu_base_url').'/oauth/authorize?'.$query);
    }

    public function getUserData(Request $request)
    {
        $state = $request->session()->pull('state');

        if(!(strlen($state) > 0 && $state === $request->state))
        {
            return redirect('/')->with('error', 'Seems like something went wrong...');
        }

        try {
            $response = Guzzle::post(config('app.osu_base_url').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('OSU_API_CLIENT_ID'),
                    'client_secret' => env('OSU_API_CLIENT_SECRET'),
                    'redirect_uri' => route('oauth-callback'),
                    'code' => $request->code,
                ],
            ]);

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong...');
        }

        $data = json_decode((string) $response->getBody(), true);
        $token = $data['access_token'];

        $userData = Guzzle::get(config('app.osu_base_url').'/api/v2/me', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        $userApi = json_decode((string) $userData->getBody(), true);

        $groupIdentifiers = array_column($userApi['groups'], 'identifier');
        $isNat = in_array('nat', $groupIdentifiers, true);

        $user = User::firstOrNew(['osu_id' => $userApi['id']]);
        $user
            ->fill([
                'isNat' => $isNat,
                'isNominator' => $isNat || in_array('bng', $groupIdentifiers, true) || in_array('bng_limited', $groupIdentifiers, true),
                'username' => $userApi['username'],
            ])
            ->save();

        auth()->login($user);

        return redirect('/');
    }

    public function logout()
    {
        auth()->logout(auth()->user());

        return redirect()->back();
    }
}
