<?php

class UserCest
{
    protected $tester;


    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }
    
    public function LoginNoUser(ApiTester $I) {
        $I->sendPOST(V.'/user/login', ['LoginForm' => ['email' => 'wrong', 'password' => 'wrong']]);
        $I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson(['code' => 401]);
    }

    // tests
    public function testGet(ApiTester $I)
    {
        $I->sendAutoAuthGET(V.'/user/get/'.TEST_ID);
        $I->seeResponseSuccessTrue();
    }
    
    public function testCreate(ApiTester $I) {
        $I->sendAutoAuthPOST(V.'/user/create',[
            'username' => 'test'.time().'test',
            'newPassword' => '123456',
            'email' => 'test@sch'.time().'ul.info',
            'is_dev' => 1
        ]);
        $I->seeResponseSuccessTrue();
    }
    
    public function testUpdate(ApiTester $I) {
        $I->sendAutoAuthPUT(V.'/user/update/5',[
            'username' => time().'test',
            'email' => 'test@sch'.time().'ultz.info',
        ]);
        $I->seeResponseSuccessTrue();
    }
}
