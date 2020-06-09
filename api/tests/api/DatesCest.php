<?php


class DatesCest
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
        $I->sendAutoAuthGET(V.'/dates/get/'.TEST_DATES_ID);
        $I->seeResponseSuccessTrue();
    }

    public function testGetList(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/dates/get-list/'.TEST_ID_GIFT_RECIEVER);
        $I->seeResponseSuccessTrue();
    }

		public function testCreate(ApiTester $I) {
        $I->sendAutoAuthPOST(V.'/dates/create',[
            'Dates[id_gift_receiver]' => TEST_ID_GIFT_RECIEVER,
            'Dates[date_m]' => 10,
			'Dates[date_d]' => 10,
			'Dates[date_y]' => 10,
			'Dates[custom_holiday]' => 'custom_holiday new column',
//			'Dates[id_holiday]' => '13',
			'Gift[from]' => 10,
			'Gift[to]' => 10,
			'Gift[newTags][0]' => 'test_tag',
			'Gift[newTags][1]' => 'test_tag2',
			'Gift[newTags][2]' => 'test_tag3',
			
            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }

    public function testUpdate(ApiTester $I) {
        $I->sendAutoAuthPUT(V.'/dates/update/'.TEST_DATES_ID,[
            'Dates[id_gift_receiver]' => TEST_ID_GIFT_RECIEVER,
            'Dates[date_m]' => 10,
			'Dates[date_d]' => 10,
			'Dates[date_y]' => 10,
			'Dates[custom_holiday]' => 'custom_holiday new column',
//			'Dates[id_holiday]' => '13',
			'Gift[from]' => 10,
			'Gift[to]' => 10,
			'Gift[newTags][0]' => 'test_tag',
			'Gift[newTags][1]' => 'test_tag2',
			'Gift[newTags][2]' => 'test_tag3',
			
            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }
}
