<?php

namespace App\Http\Controllers;

use App\User;
use App\Activation;
use App\Mail\ActivateAccount;
use App\Mail\ChangeState;
use App\Http\Resources\UserResource;
use App\Http\Resources\SmallerUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Validator;
use Swift_Mailer;
use Input;

class UserControllerAPI extends Controller
{
	
    public function getUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stateOfAccount' => 'required'
        ]);

        if ($request->wantsJson() && !$validator->fails()) {
            $users = User::where('type', 0);

            $state = $request->input('stateOfAccount');
            if ($state == '-1') {
                $users->onlyTrashed();
            } else {
                $users->where('blocked', $state);
            }

            $users = $users->get();
            return SmallerUserResource::collection($users);
        } else {
            return response()->json(['msg' => 'Request inválido.'], 400);
        }

    }

	public function getUsersForStatus(Request $request)
	{
		if ($request->wantsJson()) {
			$users = User::where('type', 0)->get();
			return UserResource::collection($users);
		} else {
			return response()->json(['message' => 'Request inválido.'], 400);
		}
	}

	public function delete($id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        $this->user = $user;
        return response()->json(null, 204);
    }


    public function updateState(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'newState' => 'required',
            'reason' => 'nullable'
        ]);

        
        if ($request->wantsJson() && !$validator->fails()) {
        	
            try {
            	error_log('Some message here.');
                $user = User::findOrFail($id);

                $newState = $request->input('newState');
                $reason = nl2br($request->input('reason'));
                $user->blocked = $newState;
                if ($newState == '0') {
                    $mensagem = "A sua conta foi reactivada.";
                    $user->reason_reactivated = $reason;
                } else {
                    $mensagem = "A sua conta foi bloqueada.";
                    $user->reason_blocked = $reason;
                }

                if ($reason != null) {
                    $mensagem .= '<br/><br/>Razão: <br/>' . $reason;
                }				

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
				Mail::to($user)->send(new ChangeState($mensagem, $user));

				$user->save();
                return response()->json(['msg' => 'Estado do utilizador alterado.']);

			} catch (\Exception $e) {
				return response()->json(['errorCode' => -1, 'msg' => 'Problema a enviar o email. Tente mais tarde novamente.', 'exc' => $e->getMessage()], 400);
			}

        } else {
            return response()->json(['errorCode' => -1, 'msg' => 'Request Invalido.'], 400);
        }
    }

	public function store(Request $request) {
        // Validator
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'username' => 'required|max:255',
			'email' => 'required|email|max:255',
			'password' => 'required|min:6'
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

	public function updateUserSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $checkEmailExists = User::where('id', '<>', $request->user()->id)
                ->where('email', $request->input('email'))
                ->first();

            if ($checkEmailExists) {
                return response()->json(
                    ['errorCode' => 1, 'msg' => 'Email já se encontra a ser utilizado.'], 400);
            }

            $checkNicknameExists = User::where('id', '<>', $request->user()->id)
                ->where('username', $request->input('username'))
                ->first();

            if ($checkNicknameExists) {
                return response()->json(
                    ['errorCode' => 2, 'msg' => 'Nome utilizador já se encontra a ser utilizado.'], 400);
            }

            $user = User::findOrFail($request->user()->id);

            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');

            $user->save();

            return response()->json(['msg' => 'Utilizador atualizado.']);


        } else {
            return response()->json(['errorCode' => -1, 'msg' => 'Request inválido.'], 400);
        }

    }

    public function updateAvatar(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image64:jpeg,jpg,png'
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $imageData = $request->get('avatar');
            $user = Auth::user();

            if ($user->avatar == "empty.png") {
                $user->avatar = $user->id . ".png";
                $user->save();
            } else {
                unlink("img/avatars/" . $user->id . ".png");
            }

            $img = Image::make($imageData);
            $img->resize(200, 200)->save("img/avatars/" . $user->id . ".png");

        } else {
            return response()->json(['msg' => 'Request inválido.'], 400);
        }

        return response()->json(200);

    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'required'
        ]);

        if ($request->wantsJson() && !$validator->fails()) {


            if (!Hash::check($request->input('currentPassword'), $request->user()->password)) {
                return response()->json(
                    ['errorCode' => 1, 'msg' => 'Password incorrecta.'], 400);
            }

            $request->user()->password = Hash::make($request->input('newPassword'));
            $request->user()->save();

            return response()->json(['msg' => 'Password alterada com sucesso.']);
        } else {
            return response()->json(['errorCode' => -1, 'msg' => 'Request inválido.'], 400);
        }
    }

    public function deleteOwnAccount(Request $request)
    {
        $this->delete($request->user()->id);
    }

	public function getUserById($id) {
		$user = User::where('id', $id)->first();
		return $user;
	}

    public function activate($id) {
-       $user = User::where('id', $id)->first();
-       if(!is_null($user)) {
-           $user->activated = 1;
-           $user->save();
-           return redirect(url('/'))->with('status', "1");
-       }else{
-           return redirect(url('/'))->with('status', "0");
-       }
-   }

}
