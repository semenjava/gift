<?php


class GiftCest
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
        $I->sendAutoAuthGET(V.'/gift/get/'.TEST_ID_GIFT);
        $I->seeResponseSuccessTrue();
    }
    
    public function testGetList(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/gift/get-list/'.TEST_DATES_ID);
        $I->seeResponseSuccessTrue();
    }
    
    public function testCreate(ApiTester $I) {
        $I->sendAutoAuthPOST(V.'/gift/create',[
            'id_dates' => TEST_DATES_ID,
            'from' => 10,
            'to' => 100,
            'describe' => 'test text ',
//            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }
    
    public function testUpdate(ApiTester $I) {
        $I->sendAutoAuthPUT(V.'/gift/update/'.TEST_ID_GIFT,[
            'id_dates' => TEST_DATES_ID,
            'from' => 100,
            'to' => 200,
            'describe' => 'test text ',
        ]);
        $I->seeResponseSuccessTrue();
    }
}
