<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the Forgot Password page works');
$I->amOnPage('/password/email');
$I->see('Forgot');
