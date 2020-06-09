<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   public function sendAutoAuthPOST($url, $params = [], $files = []) {
       $this->amBearerAuthenticated($this->getAutoToken());
		$this->sendPOST($url, $params, $files);
	}

	public function sendAuthPOST($username, $password, $url, $params = [], $files = []) {
        $this->amBearerAuthenticated($this->getToken($username, $password));
		$this->sendPOST($url, $params, $files);
	}
    
    public function sendAutoAuthGET($url, $params = [], $files = []) {
        $this->amBearerAuthenticated($this->getAutoToken());
		$this->sendGET($url, $params, $files);
	}
    
    public function sendAuthGET($username, $password, $url, $params = [], $files = []) {
        $this->amBearerAuthenticated($this->getToken($username, $password));
		$this->sendGET($url, $params, $files);
	}
    
    public function sendAutoAuthPUT($url, $params = [], $files = []) {
        $this->amBearerAuthenticated($this->getAutoToken());
		$this->sendPUT($url, $params, $files);
	}
    
    public function sendAuthPUT($username, $password, $url, $params = [], $files = []) {
        $this->amBearerAuthenticated($this->getToken($username, $password));
		$this->sendPUT($url, $params, $files);
	}

	public function seeResponseSuccessTrue() {
		$this->seeResponseCodeIs(200);
		$this->seeResponseIsJson();
		$this->seeResponseContainsJson(['code' => 200]);
	}

	public function setAndReturn($get, $set, $matches, $newData) {
		$this->sendAutoAuthPOST($get);
		$this->seeResponseMatchesJsonType($matches);
		$oldData = json_decode($this->getResponse(), true)['data'];

		$this->sendAutoAuthPOST($set, $newData);
		$this->seeResponseSuccessTrue();

		$this->sendAutoAuthPOST($get);
		$this->seeResponseContainsJson($newData);

		$this->sendAutoAuthPOST($set, $oldData);
		$this->sendAutoAuthPOST($get);
		$this->seeResponseContainsJson(['data' => $oldData]);
	}
}
