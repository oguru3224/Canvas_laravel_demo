<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Log;


class CanvasAuthController extends Controller
{
    public function redirectToCanvas(Request $request)
    {
        $state = Str::random(32);
        $nonce = Str::random(32);

        session([
            'state' => $state,
            'nonce' => $nonce,
        ]);

        $query = http_build_query([
            'response_type' => 'id_token',
            'client_id' => '10000000000026',
            'redirect_uri' => 'https://77919143b783.ngrok-free.app/lti/launch',
            'scope' => 'openid',
            'state' => $state,
            'response_mode' => 'form_post',
            'nonce' => $nonce,
            'prompt' => 'none',
            'login_hint' => $request->input('login_hint'),
            'lti_message_hint' => $request->input('lti_message_hint'),
        ]);

        return redirect('https://canvas.youeduville.com/api/lti/authorize_redirect' . '?' . $query);
    }

    public function handleLtiCallback(Request $request)
    {

        \Log::info($request->all());
        $jwt = $request->input('id_token');

        if (!$jwt) {
            return redirect()->route('canvas.login')->withErrors(['JWT not received.']);
        }
        try{
            $jwkUrl = 'https://canvas.youeduville.com/api/lti/security/jwks';
            $jwkJson = file_get_contents($jwkUrl);
            $jwkKeys = json_decode($jwkJson, true);

            $decoded = JWT::decode($jwt,JWK::parseKeySet($jwkKeys));

            $claims = (array) $decoded;

            $name = $claims['name'] ?? 'Unknown';
            $email = $claims['email'] ?? null;
            $canvasRoles = $decodedToken['https://purl.imsglobal.org/spec/lti/claim/roles'] ?? [];
            $rawRoles = $claims['https://purl.imsglobal.org/spec/lti/claim/roles'] ?? ['user'];

            $role = array_map(function ($roleUrl) {
                if (str_contains($roleUrl, '#')) {
                    return substr($roleUrl, strrpos($roleUrl, '#') + 1);
                } elseif (str_contains($roleUrl, '/')) {
                    return substr($roleUrl, strrpos($roleUrl, '/') + 1);
                }
                return $roleUrl;
            }, $rawRoles);

            $role = array_unique($role);

            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'role' => json_encode($role ?? ['user']),
                'password' => bcrypt(\Str::random(16)), // optional, not used
            ]);

            Auth::login($user);
            return view('dashboard',[
                'name' => $name,
                'email' => $email,
                'role' => $role[0],
            ]);

        } catch (\Exception $e) {
            \Log::error('JWT Decode Error: ' . $e->getMessage());
            return response()->json(['error' => 'JWT Decode Error: ' . $e->getMessage()], 400);
        }

    }
}
