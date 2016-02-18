<?php namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Models\Access\User\User;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\Frontend\Access\LoginRequest;
use App\Http\Requests\Frontend\Access\RegisterRequest;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use Socialite;
use Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use ThrottlesLogins;
    /**
     * @var UserContract
     */
    private $users;

    /**
     * @param AuthenticationContract $auth
     */
    public function __construct(AuthenticationContract $auth, UserContract $users)
    {
        $this->auth = $auth;
        $this->users = $users;
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getRegister(Request $request)
    {
        $countries = \DB::table('countries')->select(['id', 'name'])->get();

        if ( $request->old('country_id') ) {

            $states = \DB::table('states')
                ->where('country_id', $request->old('country_id'))
                ->select(['id', 'name'])
                ->get();

        } else {

            $states = \DB::table('states')
                ->where('country_id', 222)
                ->select(['id', 'name'])
                ->get();

        }

        $view = [
            'countries' => $countries,
            'states'    => $states
        ];

        return view('frontend.auth.register', $view);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        if (config('access.users.confirm_email')) {
            $user = $this->auth->create($request->all());
            $this->auth->createJobSeeker($user);
            $this->users->updateProfileCompleteness($user);
            return redirect()->route('home')->withFlashSuccess("Your account was successfully created. We have sent you an e-mail to confirm your account.");
        } else {
            //Use native auth login because do not need to check status when registering
            $user = $this->auth->create($request->all());
            $this->auth->createJobSeeker($user);
            $this->users->updateProfileCompleteness($user);
            auth()->login($user);
            return redirect()->route('home');
        }
    }

    public function validateUser(RegisterRequest $request){

        $user = $this->auth->create($request->all());
        $this->auth->createJobSeeker($user);
        $this->users->updateProfileCompleteness($user);
        \Auth::login($user);

        return response()->json(['user' => $user]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('frontend.auth.login')
            ->withSocialiteLinks($this->getSocialLinks());
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request))
            return $this->sendLockoutResponse($request);

        //Don't know why the exception handler is not catching this
        try {
            $this->auth->login($request);

            if ($throttles)
                $this->clearLoginAttempts($request);

            // Chekcing if the logged in user is a Normal User
            // and if the user has uploaded resume and saved the job preferences.
            if ( access()->hasRole('User') ) {
                return redirect()->intended('/');
            } else {
                return redirect()->intended('/dashboard');
            }

        } catch (GeneralException $e) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles)
                $this->incrementLoginAttempts($request);

            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $provider
     * @return mixed
     */
    public function loginThirdParty(Request $request, $provider)
    {
        return $this->auth->loginThirdParty($request->all(), $provider);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect()->route('home');
    }

    /**
     * @param $token
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirmAccount($token)
    {
        //Don't know why the exception handler is not catching this
        try {
            $this->auth->confirmAccount($token);

            /**
             * Check if the user does not have password and does not have the Social logins.
             * If true, then we should show them that we have sent a password reset request.
             * If not, simply show account confirmed message.
             */

            $user = User::where('confirmation_code', $token)->first();

            if ( $user->no_password && ( ! $user->providers->count() ) ) {

                $this->auth->sendPasswordResetMailForEmployer($user);

                alert()
                    ->message('Your account has been confirmed. An email has been sent to reset your password.', 'Account confirmed')
                    ->autoclose(3500);
            } else {
                alert()
                    ->message('Your account has been successfully confirmed!. Now, please login', 'Account confirmed')
                    ->autoclose(3500);
            }
            return redirect()->route('home');

        } catch (GeneralException $e) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function resendConfirmationEmail($user_id)
    {
        //Don't know why the exception handler is not catching this
        try {
            $this->auth->resendConfirmationEmail($user_id);
            return redirect()->route('home')->withFlashSuccess("A new confirmation e-mail has been sent to the address on file.");
        } catch (GeneralException $e) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * Helper methods to get laravel's ThrottleLogin class to work with this package
     */

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    /**
     * Generates social login links based on what is enabled
     * @return string
     */
    protected function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';

        if (getenv('GITHUB_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Github']), 'github');

        if (getenv('FACEBOOK_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Facebook']), 'facebook');

        if (getenv('TWITTER_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Twitter']), 'twitter');

        if (getenv('GOOGLE_CLIENT_ID') != '')
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Google']), 'google');

        for ($i = 0; $i < count($socialite_enable); $i++) {
            $socialite_links .= ($socialite_links != '' ? '&nbsp;|&nbsp;' : '') . $socialite_enable[$i];
        }

        return $socialite_links;
    }

    public function linkedinRedirectToProvider() {
        return Socialite::driver('linkedin')->scopes(['email'])->redirect();
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    public function linkedinHandleProviderCallback() {

        $user = Socialite::driver('linkedin')->user();

        $user = $this->users->findByUserNameOrCreate($user, 'linkedin');

        if ( ! $user->jobseeker_details ) {
            $this->auth->createJobSeeker($user);
        }

        $this->users->updateProfileCompleteness($user);

        Auth::login($user, true);

        event(new UserLoggedIn($user));

        return redirect()->intended($this->redirectPath());

    }

    public function linkedinConnectRedirectToProvider(){
        return Socialite::driver('linkedin')->scopes(['email'])->redirect();
    }

    public function linkedinConnectHandleProviderCallback() {

        $user = Socialite::driver('linkedin')->user();

        $user = $this->users->findByUserNameOrCreate($user, 'linkedin');

        $this->users->updateProfileCompleteness($user);

        return redirect()->intended(route('frontend.profile.socialmedia'));

    }

    public function facebookRedirectToProvider(){
        return Socialite::driver('facebook')->scopes(['email'])->redirect();
    }

    public function facebookHandleProviderCallback() {

        $user = Socialite::driver('facebook')->user();

        $user = $this->users->findByUserNameOrCreate($user, 'facebook');

        $this->users->updateProfileCompleteness($user);

        return redirect()->intended(route('frontend.profile.socialmedia'));

    }

    public function twitterRedirectToProvider(){
        return Socialite::driver('twitter')->scopes(['email'])->redirect();
    }

    public function twitterHandleProviderCallback(){

        $user = Socialite::driver('twitter')->user();

        $this->users->findByUserNameOrCreate($user, 'twitter');

        return redirect()->intended(route('frontend.profile.socialmedia'));
    }
    
    public function googleRedirectToProvider(){
        return Socialite::driver('google')->scopes(['email'])->redirect();
    }

    public function googleHandleProviderCallback(){

        $user = Socialite::driver('google')->user();

        $user = $this->users->findByUserNameOrCreate($user, 'google');

        $this->users->updateProfileCompleteness($user);

        return redirect()->intended(route('frontend.profile.socialmedia'));
    }

}
