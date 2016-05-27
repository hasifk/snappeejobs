<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the Employers page works');
$I->amOnPage('/employers');
$I->see('START HIRING');
