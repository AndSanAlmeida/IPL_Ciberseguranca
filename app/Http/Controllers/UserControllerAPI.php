<?php

namespace App\Http\Controllers;

use App\User;
use App\Activation;
use App\Mail\ActivateAccount;
use App\Http\Resources\UserResource;

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

class UserControllerAPI extends Controller
{
    public function getUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'searchText' => 'nullable',
            'stateOfAccount' => 'required'
        ]);

        if ($request->wantsJson() && !$validator->fails()) {
            $users = User::where('admin', 0);
            $searchText = $request->input('searchText');

            if ($searchText) {
                $users->where(function ($q) use ($searchText) {
                    $q->where('email', 'like', '%' . $searchText . '%');
                    $q->orWhere('nickname', 'like', '%' . $searchText . '%');
                    $q->orWhere('name', 'like', '%' . $searchText . '%');
                });
            }
            $state = $request->input('stateOfAccount');
            if ($state == '-1') {
                $users->onlyTrashed();
            } else {
                $users->where('blocked', $state);
            }
            $users = $users->get();
            return UserResource::collection($users);
        } else {
            return response()->json(['msg' => 'Request inválido.'], 400);
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

	public function activate($id) {
		$user = User::where('id', $id)->first();
		if(!is_null($user) ){
			$user->activated = 1;
			$user->save();
			return redirect(url('/'))->with('status', "1");
		}else{
			return redirect(url('/'))->with('status', "0");
		}
	}

	public function user(Request $request)
	{
		$user = User::find(Auth::user()->id);
		return response([
			'status' => 'success',
			'data' => $user
		]);
	}
	public function refresh()
	{
		return response([
			'status' => 'success'
		]);
	}

	public function getNewUsers(Request $request)
	{
		if ($request->wantsJson()) {
			$users = User::where('admin', 0)->where('blocked', 0)->where('activated', 0)->get();
			return UserResource::collection($users);
		} else {
			return response()->json(['message' => 'Request inválido.'], 400);
		}
	}
}
