<?php

namespace Helper;


// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module {

    public static $authTokens = [];
    public static $currentToken = null;

    public function getAutoToken() {
        if (empty(self::$currentToken)) {
            $this->getModule('REST')->sendPOST('v1/user/login', ['LoginForm' => ['email' => TEST_USERNAME, 'password' => TEST_PSWD]]);
            self::$currentToken = json_decode($this->getModule('REST')->response)->data->access_token;
        }

        return self::$currentToken;
    }

    public function getToken($username, $password) {
        if (empty(self::$authTokens["{$username}__{$password}"])) {
            $this->getModule('REST')->sendPOST('v1/user/login', ['LoginForm' => ['email' => $username, 'password' => $password]]);
            self::$authTokens["{$username}__{$password}"] = json_decode($this->getModule('REST')->response)->data->access_token;
        }

        return self::$authTokens["{$username}__{$password}"];
    }

    public function getResponse() {
        return $this->getModule('REST')->response;
    }

    public function isResponseDataEmpty() {
        return empty(json_decode($this->getModule('REST')->response)->user);
    }

    public function getId() {
        return json_decode($this->getModule('REST')->response)->user->id;
    }

}
