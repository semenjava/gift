<?php


class ProductCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function testGet(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/product/get/2');
        $I->seeResponseSuccessTrue();
    }
    
    public function testGetList(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/product/get-list/11/10/0');
        $I->seeResponseSuccessTrue();
    }
    
    public function testSearch(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/product/search/product');
        $I->seeResponseSuccessTrue();
    }
    
    public function testSearchCategory(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/product/search/product/11');
        $I->seeResponseSuccessTrue();
    }
}
