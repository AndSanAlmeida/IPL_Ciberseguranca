<?php
namespace App\Http\Controllers;

use App\User;
use App\Activation;
use App\Mail\ActivateAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Validator;
use Swift_Mailer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Input;

class UserController extends Controller
{
	public function register(Request $request) {
        // Validator
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'username' => 'required|max:255',
			'email' => 'required|email|max:255',
			'password' => 'required|min:6',
			'date' => 'required|date',
		]);

		if ($request->wantsJson() && !$validator->fails()) {

			try {
				// Verificação do email unico
				$checkEmailExists = User::where('email', $request->input('email'))->first();
				if ($checkEmailExists) {
					return response()->json(
						['errorCode' => 1, 'msg' => 'Email já está em uso.'], 400);
				}

				// Verificação do username unico
				$checkUsernameExists = User::where('username', $request->input('username'))->first();
				if ($checkUsernameExists) {
					return response()->json(
						['errorCode' => 2, 'msg' => 'Username já está em uso.'], 400);
				}

				// Criação do User na DB
				$user= new User();
				$user->name = $request->name;
				$user->email = $request->email;
				$user->username = $request->username;
				$user->password = bcrypt($request->password);
				$user->date_of_birth = $request->date;
				$user->save();

				// Criar link de activação
				$activation = new Activation();
				$activation->user_id = $user->id;
				$activation->token = str_random(64);
				$activation->save();

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
				Mail::to($user)->send(new ActivateAccount($user));

				return response()->json(['msg' => 'Utilizador criado.']);

			} catch (\Exception $e) {
				return response()->json(['errorCode' => -1, 'msg' => 'Problema a enviar o email. Tente mais tarde novamente.', 'exc' => $e->getMessage()], 400);
			}
		} else {
			return response()->json(['errorCode' => -1, 'msg' => 'Request Invalido.'], 400);
		}
	}
	
	public function login(Request $request) {
		$this->validate($request,[
			'email' => 'required|email',
			'password' => 'required|min:6',
		]);
		$crediential=$request->only('email','password');
		
		if(!$token=JWTAuth::attempt($crediential)){
			return "Not Authenticated";
		}
		return ['token'=>$token];
		
	}

	public function activate($token) {
		$activate = Activation::where('token', $token)->first();
        if(isset($activate) ){
            $user = $activate->user;
            if(!$user->activated) {
                $user->activated = 1;
                $user->save();
                return redirect(url('/'))->with('status', "1");
            }else{
            	return redirect(url('/'))->with('status', "1");
            }
        }else{
            return redirect(url('/'))->with('status', "0");
        }
	}
}