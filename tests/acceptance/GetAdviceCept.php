<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure the getadvice page works');
$I->amOnPage('/advice');
$I->see('Career');

