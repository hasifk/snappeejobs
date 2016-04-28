@if(auth()->user() && !auth()->user()->confirmed)
<div style="margin-top: 100px;" class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-info">
                You have not yet confirmed your account.
                Please do so by following the instructions sent to you by email.
                Click <a href="{{ route('account.confirm.resend', auth()->user()->id) }}">here</a> to re-send the email.
            </div>
        </div>
    </div>
</div>
@endif

