<?php

namespace Tests\Functional;

use tests\Functional\_support\FunctionalTester;

class HomepageCest
{
    public function homepageCheck(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->see('Docker Symfony', 'title');
    }

}
