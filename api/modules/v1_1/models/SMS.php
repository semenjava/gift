<?php
namespace app\modules\v1_1\models;

use Yii;
use SoapClient;

class SMS{

  private $sender='';
  private $login='';
  private $pwd=''; 
  private $host='';
  private $table=''; 
  
  private function __construct($sender) {
      $this->host = Yii::$app->params['turbosms']['host'];
      $this->login = Yii::$app->params['turbosms']['login'];
      $this->pwd = Yii::$app->params['turbosms']['pass'];
      $this->table = Yii::$app->params['turbosms']['table'];
      $this->sender = $sender;
  }
  
  /**
   *  $r - Recipient
   *  $m - Message
   *  $d - Date, default "NOW()"
   */     
  public function send($r,$m,$d=false){
    try{
        
        
    	$pdo = new PDO ("mysql:host=".$this->host.";dbname=".$this->table,$this->login,$this->pwd);
    	$pdo->query("SET NAMES utf8;");
	    if($d==false)
	      $pdo->query("INSERT INTO `{$this->login}` (`number`,`message`,`sign`) VALUES ('$r','$m','chili')");
	    else
	      $pdo->query("INSERT INTO `{$this->login}` (`number`,`message`,`sign`,`send_time`) VALUES ('$r','$m','{$this->sender}','$d')");
    }catch(Exception $e){
			$client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html'); 
			$auth = array( 
                            'login' => $this->login, 
                            'password' => $this->pwd 
        	); 
        	$res=$client->Auth($auth);
        	$sms = array( 
        		'sender' => $this->$sender, 
        		'destination' => $r, 
		        'text' => $m
        	);
        	$res=$client->SendSMS($sms); 
    }
  }
}

