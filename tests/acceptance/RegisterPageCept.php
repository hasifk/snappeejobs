<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the Login page works');
$I->amOnPage('auth/register');
$I->see('Register');
