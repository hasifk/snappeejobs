<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the company search page works');
$I->amOnPage('/companies?search=1');
$I->see('Search');