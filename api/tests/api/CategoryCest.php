<?php


class CategoryCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function testGetList(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/category/get-list',[]);
        $I->seeResponseSuccessTrue();
    }
}
