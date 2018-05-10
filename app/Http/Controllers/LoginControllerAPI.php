<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPassword;
use App\User;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Swift_Mailer;
use Auth;
use GuzzleHttp\Client as Client;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


//define('YOUR_SERVER_URL', 'http://ipl.test');
define('YOUR_SERVER_URL', 'http://ipl_ciberseguranca.test');
define('CLIENT_ID', '2');
define('CLIENT_SECRET', 'ozS5vpC5IAltONJja2g7FimFuSGOlbr5A5KnwMxJ');

class LoginControllerAPI extends Controller
{
    use SendsPasswordResetEmails;
    
    public function login(Request $request)
    {

        $user = User::orWhere('email', $request->username)->orWhere('username', $request->username)->first();
        if (!$user) {
            return response()->json(['data' => 'Utilizador não encontrado.'],400);
            var_dump(response()->json(['data' => 'Utilizador não encontrado.'],401));
        }
        
        if ($user->blocked == 1) {
            return response()->json(['data' => 'Utilizador bloqueado.'], 400);
        }
        
        if ($user->activated == 0) {
            return response()->json(['data' => 'Utilizador não ativado.'], 400);
        }
        
        $http = new \GuzzleHttp\Client;
        $response = $http->post(YOUR_SERVER_URL.'/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => CLIENT_ID,
                'client_secret' => CLIENT_SECRET,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => ''
            ], 'exceptions' => false,]);

        $errorCode= $response->getStatusCode();
        if ($errorCode=='200') {
            return json_decode((string) $response->getBody(), true);
        } else {
            return response()->json(['data'=>'Credenciais do utilizador inválidas.'], $errorCode);
        }

    }

    public function logout()
    {
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg'=>'Token revoked'], 200);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($request->wantsJson() && !$validator->fails()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json(['msg' => trans('passwords.user')], 400);
            }

            $token = $this->broker()->createToken($user);

            try {

                $config = DB::table('config')->first();
                $mailConfigs = json_decode($config->platform_email_properties);

                config([
                    'mail.host' => $mailConfigs->host,
                    'mail.port' => $mailConfigs->port,
                    'mail.encryption' => $mailConfigs->encryption,
                    'mail.username' => $config->platform_email,
                    'mail.password' => $mailConfigs->password
                ]);

                $app = App::getInstance();
                $app->singleton('swift.transport', function ($app) {
                    return new TransportManager($app);
                });
                $mailer = new Swift_Mailer($app['swift.transport']->driver());
                Mail::setSwiftMailer($mailer);

                Mail::to($user->email)->queue(new RecoverPassword($token, $user->email, $config->platform_email));
                return response()->json(['msg' => 'Email enviado.']);
            } catch (\Exception $e) {
                return response()->json(['msg' => 'Erro ao enviar email.', 'exc' => $e->getMessage()], 400);
            }
        } else {
            return response()->json(['msg' => 'Request inválido.'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required'
        ]);
        if ($request->wantsJson() && !$validator->fails()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json(['msg' => 'Nenhum utilizador encontrado com esse email.']);
            }
            $reminder = DB::table('password_resets')->where('email', $user->email)->first();
            if (!$reminder or !Hash::check($request->input('token'), $reminder->token)) {
                return response()->json(['data' => 'Token valido.'], 400);
            }
            $user->password = Hash::make($request->input('password'));
            $user->save();
            DB::table('password_resets')->where('email', $user->email)->delete();
            return response()->json(['data' => 'Password alterada.'], 200);
        } else {
            return response()->json(['data' => 'Request inválido.'], 400);
        }
    }
}
