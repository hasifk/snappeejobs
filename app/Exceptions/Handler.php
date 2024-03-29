<?php namespace App\Exceptions;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Exceptions\Backend\Access\Employer\Mail\MessageDoesNotBelongToUser;
use App\Exceptions\Backend\Access\Employer\Settings\SubscriptionPlanException;
use App\Exceptions\Backend\Company\CompanyNeedDataFilledException;
use App\Exceptions\Backend\Project\ProjectDoesNotBelongToUser;
use App\Exceptions\Frontend\Job\JobDoesNotExist;
use App\Exceptions\Frontend\Profile\ThreadDoesNotExists;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
		ModelNotFoundException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof ModelNotFoundException) {
			$e = new NotFoundHttpException($e->getMessage(), $e);
		}

		//As to preserve the catch all
		if ($e instanceof GeneralException)
		{
			return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
		}

		if ($e instanceof Backend\Access\User\UserNeedsRolesException)
		{
			return redirect()->route('admin.access.users.edit', $e->userID())->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof EmployerNeedsRolesException)
		{
			return redirect()->route('admin.employer.staffs.index')->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof MessageDoesNotBelongToUser)
		{
			return redirect()->route('admin.employer.mail.inbox')->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof SubscriptionPlanException)
		{
			return redirect()->route('admin.employer.settings.chooseplanupgrade')->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof JobDoesNotExist)
		{
			return redirect()->route('admin.employer.jobs.index')->withInput()->withFlashDanger($e->validationErrors());
		}
		if ($e instanceof CompanyNeedDataFilledException)
		{
			return redirect()->route('backend.dashboard')->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof ThreadDoesNotExists)
		{
			return redirect()->route('frontend.messages')->withInput()->withFlashDanger($e->validationErrors());
		}

		if ($e instanceof ProjectDoesNotBelongToUser)
		{
			return redirect()->route('admin.projects.index')->withInput()->withFlashDanger($e->validationErrors());
		}

		//Catch all
		return parent::render($request, $e);
	}
}
