<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Auth;
use Guzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OauthController extends Controller
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

        $osuUserId = $userApi['id'];
        $username = $userApi['username'];

        $viableGroupids = [7, 28, 32];
        $isBnOrNat = false;

        foreach ($viableGroupids as $id) {
            if (in_array($id, array_column($userApi['groups'], 'id'))) {
                $isBnOrNat = true;
                break;
            }
        }

        $user = User::where('osu_id', $osuUserId)->first();

        if ($user === null) {
            User::create([
                'isNominator' => $isBnOrNat,
                'osu_id' => $osuUserId,
                'username' => $username,
            ]);

            return redirect('/login');
        }

        if ($isBnOrNat === true) {
            $user->update([
                'isNominator' => true,
            ]);
        }

        Auth::login($user);

        return redirect('/');
    }
}
