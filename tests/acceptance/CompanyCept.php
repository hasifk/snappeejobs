<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the companies page works');
$I->amOnPage('/companies');
$I->see('Browse');