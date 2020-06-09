<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Gender;

class GeneratorController extends Controller {

	public $relations = [
		1 => 'Parent',
		2 => 'Child',
		3 => 'Sibling',
		4 => 'Relative',
		5 => 'Friend',
		6 => 'Сolleague',
		7 => 'Familiar',
	];

	public $hobbies = [
		1 => 'Tourism',
		2 => 'Hunting',
		3 => 'Fishing',
		4 => 'Bird watching',
		5 => 'Dancing',
		6 => 'Paintball',
		7 => 'Strikeball',
		8 => 'Historical Reconstruction',
		9 => 'Railway hobbies',
		10 => 'Amateur astronomy',
		11 => 'Floriculture',
		12 => 'Gardening',
		13 => 'Needlework',
		14 => 'Cooking',
		15 => 'amateur theater',
		16 => 'Computer games',
		17 => 'Board games',
	];

	public $holidays = [
		1 => ['Birthday', null,],
		['New Year`s Day', '21 january',],
		['Martin Luther King Jr. Day', 'third monday of january',],
		['Washington`s Birthday', 'third monday of february',],
		['Memorial Day', 'last monday of may',],
		['Independence Day', '4 july',],
		['Labor Day', 'first monday of september',],
		['Columbus Day', 'second monday of october',],
		['Veterans Day', '11 november',],
		['Thanksgiving', 'fourth thursday of november',],
		['Christmas', '25 december',],
	];

	public function actionIndex($idUser, $receiversCnt = 20) {
		$user = \common\models\User::findOne($idUser);

		if (empty($user)) {
			echo 'add real user id as `?idUser=2`';die();
		}

		$faker = \Faker\Factory::create();

		Yii::$app->db->createCommand(
			"SET FOREIGN_KEY_CHECKS = 0;
			TRUNCATE table `gift_receiver`;
			TRUNCATE table `dates`;
			TRUNCATE table `gift`;
			TRUNCATE table `gift_tag`;
			TRUNCATE table `holiday`;
			TRUNCATE table `relation`;
			TRUNCATE table `tag`;
			SET FOREIGN_KEY_CHECKS = 1;"
		)->execute();

		$this->addHolidays();
		$this->addRelations();
		$this->addTags();

		for ($i=0; $i < $receiversCnt; $i++) {
			list($idGiftReceiver, $month, $day) = $this->addGiftReceiver($faker, $idUser);
			$this->addBirthdayDates($faker, $idGiftReceiver, $month, $day);
			$this->addRandomDates($faker, $idGiftReceiver);
			$this->addRandomDates($faker, $idGiftReceiver);
		}
	}

	private function addGiftReceiver($faker, $idUser) {
		$gender = rand(1,6);
		if (in_array($gender, [Gender::MALE, Gender::GAY])) {
			$sex = 'male';
		} elseif (in_array($gender, [Gender::WOMEN, Gender::LESBIAN])) {
			$sex = 'female';
		} else {
			$sex = rand(0,1) ? 'male' : 'female';
		}

		$birthday = $faker->dateTimeBetween('-70 years', '-3 years');

		$model = new \common\models\GiftReceiver();
		$model->first_name = $faker->firstName($sex);
		$model->last_name = $faker->lastName($sex);
		$model->email = $faker->email;
		$model->phone = $faker->e164PhoneNumber;
		$model->birthday_day = $birthday->format('d');
		$model->birthday_month = $birthday->format('m');
		$model->birthday_year = $birthday->format('Y');

		$model->describe = $faker->text;
		$model->gender = $gender;
		$model->id_user = $idUser;
		$model->is_active = true;
		$model->id_relation = rand(1, count($this->relations));

		$model->address_type = '1';
		$model->id_country = '211';

		$model->city = $faker->city;
		$model->zip = $faker->postcode;
		$model->address1 = $faker->streetAddress;
		$model->save();

		return [$model->id, $model->birthday_month, $model->birthday_day];
	}

	private function addRandomDates($faker, $idGiftReceiver) {
		$idHoliday = rand(2, count($this->holidays));
		$time = strtotime($this->holidays[$idHoliday][1]);
		$this->addDates($faker, $idGiftReceiver, date('m', $time), date('d', $time), $idHoliday);
	}

	private function addBirthdayDates($faker, $idGiftReceiver, $month, $day) {
		$this->addDates($faker, $idGiftReceiver, $month, $day, 1);
	}

	private function addDates($faker, $idGiftReceiver, $month, $day, $idHoliday) {
		$dates = new \common\models\Dates();
		$gift = new \common\models\Gift();

		$dates->id_gift_receiver = $idGiftReceiver;
		$dates->id_holiday = $idHoliday;
		$dates->date_d = $day;
		$dates->date_m = $month;
		$dates->save();

		$gift->id_dates = $dates->id;
		$gift->from = rand(0, 10) * 100;
		$gift->to = rand(10, 50) * 100;

		$tags = [];
		$col = rand(1, 3);
		for ($j = 0; $j < $col; $j++) {
			$tags[] = $this->hobbies[rand(1, 10)];
		}
		$gift->newTags = array_unique($tags);
		$gift->save();
	}

	private function addHolidays() {
		foreach ($this->holidays as $id => $value) {
			$model = new \common\models\Holiday();
			$model->id = $id;
			$model->name = $value[0];
			$model->strtotime = $value[1];
			$model->is_birthday = empty($value[1]) ? 1 : 0;
			$model->save();
		}
	}

	private function addRelations() {
		foreach ($this->relations as $id => $name) {
			$model = new \common\models\Relation();
			$model->id = $id;
			$model->name = $name;
			$model->is_active = 1;
			$model->save();
		}
	}


	private function addTags() {
		foreach ($this->hobbies as $id => $name) {
			$model = new \common\models\Tag();
			$model->id = $id;
			$model->name = $name;
			$model->save();
		}
	}

}
