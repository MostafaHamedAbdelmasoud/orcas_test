<?php

namespace App\Domain\User\Http\Controllers\Auth;

use App\Domain\User\Entities\User;
use App\Domain\User\Http\Requests\Auth\UserLoginFormRequest;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MostafaHamed\DDD\Traits\Responder;

class LoginController extends Controller
{
    use Responder;
    /**
     * View Path.
     *
     * @var string
     */
    protected $viewPath = 'user';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'users';

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'users';

    protected $userRepository;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view("{$this->domainAlias}::{$this->viewPath}.auth.login", [
            'title' => __('main.login')
        ]);
    }

    public function login(UserLoginFormRequest $request)
    {
        $user = $this->userRepository->findByField('email',$request->validated()['email'])->first();

        if (!$user || !Hash::check($request->validated()['password'], $user->password)) {
            return response()->json([
                'message' => 'Please check your credentials',
            ], 401);

        }

        $this->setData('data', $user);
        $this->useCollection(UserResource::class, 'data');
        if ($request->wantsJson()) {

            $this->setData('meta', [
                'token' => $user->createToken('Laravel Password Grant Client')->accessToken, //todo add function to generate token
            ]);
        }
        else{
            Auth::login($user);
        }
        $this->redirectRoute('dashboard');

        return $this->response();
    }

    /**
     * @Override
     *
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated()
    {
        if (auth()->check()) {
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->intended($this->redirectPath());
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if($request->wantsJson())
        {
            $token = $request->user()->token();
            $token->revoke();
            $response = 'You have been successfully logged out!';
            return new JsonResponse(['message' => $response], 200);
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return  redirect('/');
    }
}
