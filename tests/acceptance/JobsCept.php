<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the jobs page works');
$I->amOnPage('/jobs');
$I->see('Browse');
