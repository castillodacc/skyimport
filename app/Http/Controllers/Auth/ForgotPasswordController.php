<?php

namespace skyimport\Http\Controllers\Auth;

use skyimport\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use skyimport\Http\Requests\RecoverUserPassRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($request, $response)
        : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return mixed
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => trans($response)
            ]);
        }
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param $response
     * @return mixed
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return new JsonResponse(['email' => trans($response) ], 422);
        }
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('adminlte::auth.passwords.email');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function viewRecoverPass($id)
    {
        $user = \skyimport\User::where('id', '=', $id)->first();

        $longitud = strlen($user->password);
        if ($longitud < 5) {
            $num = rand(1000, 9999);
            $user->update(['password' => $num]);
            \Mail::to($user->email)->send(new \skyimport\Mail\Recovery($num));
        }
        if ($user) {
            return view('users.recovery_user', ['user' => $user]);
        }
        return redirect()->to('/');
    }

    public function recoverPass($id, RecoverUserPassRequest $request)
    {
        $user = \skyimport\User::where('id', '=', $id)
        ->where('password', '=', $request->_codigo)
        ->where('num_id', '=', $request->number_id)
        ->first();

        if ($user) {
            $user->update(['password' => bcrypt($request->password)]);
            \Auth::loginUsingId($id);
        }

        return redirect()->to('/');
    }
}
