<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the jobs page works');
$I->amOnPage('/jobs?search=1');
$I->see('Search');
