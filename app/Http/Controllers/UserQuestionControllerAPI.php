<?php

namespace App\Http\Controllers;

use App\UserQuestion;
use App\User;
use App\Http\Resources\UserQuestionResource;
use Swift_Mailer;
use App\Mail\QuestionAnswered;
use Illuminate\Support\Facades\App;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class UserQuestionControllerAPI extends Controller
{
    public function notAnswered(Request $request)
	{
		if ($request->wantsJson()) {
			$notAnsweredQuestions = UserQuestion::where('isAnswered', 0)->get();
			return UserQuestionResource::collection($notAnsweredQuestions);
		} else {
			return response()->json(['message' => 'Request inválido.'], 400);
		}
	}

	public function answered(Request $request)
	{
		if ($request->wantsJson()) {
			$answeredQuestions = UserQuestion::where('isAnswered', 1)->get();
			return UserQuestionResource::collection($answeredQuestions);
		} else {
			return response()->json(['message' => 'Request inválido.'], 400);
		}
	}

	public function deleteQuestion($id) {
		$notAnsweredQuestions = UserQuestion::findOrFail($id);

        $notAnsweredQuestions->delete();

        return response()->json(['msg' => 'Pergunta apagada com sucesso.']);
	}

	public function answer(Request $request) {
		$validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
           
            try {
            	$question = UserQuestion::findOrFail($request->get('id'));
            	$question->answer = $request->get('answer');
            	$question->isAnswered = 1;

                $user = User::findOrFail($question->user_id);

                $mensagem = "A sua pergunta foi respondida por um responsável da Oficina de Cibersegurança";
                $questionText= "Questão:" . $question->question;
                $answerText = "Resposta:" . $request->get('answer');		

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
				Mail::to($user)->send(new QuestionAnswered($mensagem, $questionText, $answerText, $user, $config->platform_email));

				$question->save();
                return response()->json(['msg' => 'Questão respondida.']);

			} catch (\Exception $e) {
				return response()->json(['errorCode' => -1, 'msg' => 'Problema a enviar o email. Tente mais tarde novamente.', 'exc' => $e->getMessage()], 400);
			}




            $question->update();
            return response()->json(['msg' => 'Pergunta respondida com sucesso', 'error' => false]);
        }
	}

	public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $userQuestions = UserQuestion::all();

            return UserQuestionResource::collection($userQuestions);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function store(Request $request) {
    	$validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $question = new UserQuestion;
            $question->question = $request->get('question');
            $question->user_id = $request->get('user_id');
            $question->isAnswered = 0;
	        $question->isFAQ = 0;
            
            $question->save();
            return response()->json(['msg' => 'Pergunta registada com sucesso.', 'error' => false]);
        }
    }
}
