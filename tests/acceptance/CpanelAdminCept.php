<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Log in to Admin Dashboard');
$I->amOnPage('/auth/login');
$I->fillField('email', 'admin@admin.com');
$I->fillField('password', 'eeppans');
$I->click('#login');
$I->see('Dashboard');
$I->amOnPage('/profile/edit');
$I->see('Update');
$I->amOnPage('/auth/password/change');
$I->see('Change');
$I->amOnPage('/profile/favourites');
$I->see('Favourites');
$I->amOnPage('/admin/dashboard');
$I->see('Employer Count');
$I->amOnPage('/admin/access/users');
$I->see('User Management');
$I->amOnPage('/admin/subscription');
$I->see('subscription');
$I->amOnPage('/admin/companies');
$I->see('Company Management');
$I->amOnPage('/admin/jobseekers');
$I->see('JobSeekers');
$I->amOnPage('/admin/newsfeeds');
$I->see('News Feed');
$I->click('#newnewsfeed');
$I->see('News Feed');
$I->amOnPage('/admin/cms');
$I->see('CMS Management');
$I->amOnPage('/admin/cms_create');
$I->see('CMS Management');
$I->amOnPage('/admin/cms');
$I->amOnPage('/admin/cms/lists/article');
$I->see('CMS Management');


