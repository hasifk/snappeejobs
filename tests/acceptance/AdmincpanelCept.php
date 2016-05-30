<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Log in to Admin Dashboard');
$I->amOnPage('/auth/login');
$I->fillField('email', 'admin@admin.com');
$I->fillField('password', 'eeppans');
$I->click('#login');
$I->see('Dashboard');


$I1 = new AcceptanceTester($scenario);
$I1->wantTo('Ensure Profile Update works');
$I1->amOnPage('/profile/edit');
$I1->see('Update');

$I2 = new AcceptanceTester($scenario);
$I2->wantTo('Ensure Change Password works');
$I2->amOnPage('/auth/password/change');
$I2->see('Change');

$I3 = new AcceptanceTester($scenario);
$I3->wantTo('Ensure favourites page works');
$I3->amOnPage('/profile/favourites');
$I3->see('Favourites');

$I4 = new AcceptanceTester($scenario);
$I4->wantTo('Ensure admin dashboard page works');
$I4->amOnPage('/admin/dashboard');
$I4->see('Employer Count');

$I5 = new AcceptanceTester($scenario);
$I5->wantTo('Ensure admin access management page works');
$I5->amOnPage('/admin/access/users');
$I5->see('User Management');

$I6 = new AcceptanceTester($scenario);
$I6->wantTo('Ensure admin subscription management page works');
$I6->amOnPage('/admin/subscription');
$I6->see('subscription');

$I7 = new AcceptanceTester($scenario);
$I7->wantTo('Ensure admin company management page works');
$I7->amOnPage('/admin/companies');
$I7->see('Company Management');

$I8 = new AcceptanceTester($scenario);
$I8->wantTo('Ensure admin Jobseekers page works');
$I8->amOnPage('/admin/jobseekers');
$I8->see('JobSeekers');

$I9 = new AcceptanceTester($scenario);
$I9->wantTo('Ensure admin NewsFeeds page works');
$I9->amOnPage('/admin/newsfeeds');
$I9->click('#newnewsfeed');
$I9->see('News Feed');
/*
$I10 = new AcceptanceTester($scenario);
$I10->wantTo('Ensure admin Cms page works');
$I10->amOnPage('/admin/cms');
$I10->click('#cms_create');
$I10->see('CMS Management');
$I10->click('#cms_all');
$I10->see('CMS Management');
$I10->click('#cms_articles');
$I10->see('CMS Management');
$I10->click('#cms_blogs');
$I10->see('CMS Management');*/

