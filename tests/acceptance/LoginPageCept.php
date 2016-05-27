<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the Login page works');
$I->amOnPage('auth/login');
$I->see('Login');
