<?php


class GiftReceiverCest
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
        $I->sendAutoAuthGET(V.'/gift-receiver/get/'.TEST_ID_GIFT_RECIEVER);
        $I->seeResponseSuccessTrue();
    }
    
    public function testGetList(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/gift-receiver/get-list/'.ID_USER.'/10/0');
        $I->seeResponseSuccessTrue();
    }
	
	public function testGetAddressType(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/gift-receiver/get-address-type');
        $I->seeResponseSuccessTrue();
    }
	
	public function testGetCountry(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/gift-receiver/get-country');
        $I->seeResponseSuccessTrue();
    }
    
    public function testCreate(ApiTester $I) {
        $I->sendAutoAuthPOST(V.'/gift-receiver/create',[
            'first_name' => 'test'.time(),
			'last_name' => 'test2'.time(),
			'email' => 'test'.time().'@test.ua',
			'phone' => '+1(066) 111-11-37',
			'gender' => 2,
			'id_user' => 2,
			'is_active' => 1,
			'birthday_day' => '28',
			'birthday_month' => '4',
//			'birthday_year' => '1985',
			'approximateAge' => '1985',
			'id_relation' => '1',
			'address_type' => '1',
			'id_country' => '1',
			'city' => 'Babruisk',
			'address1' => 'Street 3 tarakana',
			'custom_state' => 'custom_state test',
            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }
    
    public function testUpdate(ApiTester $I) {
        $I->sendAutoAuthPUT(V.'/gift-receiver/update/'.TEST_ID_GIFT_RECIEVER,[
            'first_name' => 'test'.time(),
			'last_name' => 'test2'.time(),
			'email' => 'test'.time().'@test.ua',
			'phone' => '+1(066) 111-11-37',
			'gender' => 2,
			'id_user' => 2,
			'is_active' => 1,
			'birthday_day' => '28',
			'birthday_month' => '4',
//			'birthday_year' => '1985',
			'approximateAge' => '1985',
            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }
}
