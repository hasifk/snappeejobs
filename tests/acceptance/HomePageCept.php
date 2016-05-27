<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure the home page works');
$I->amOnPage('/');
$I->see('Home');
