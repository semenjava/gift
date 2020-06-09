<?php


class HolidayCest
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
        $I->sendAutoAuthGET(V.'/holiday/get-list',[]);
        $I->seeResponseSuccessTrue();
    }
}
