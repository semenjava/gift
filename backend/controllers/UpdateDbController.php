<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class UpdateDbController extends Controller {


	/**
	 *
	 * @return type
	 */
	public function accessRules() {
		return [
			['allow', // allow all users to perform 'index' and 'view' actions
				'actions' => ['index'],
				'users' => ['*'],
			],
			['deny', // deny all users
				'users' => ['*'],
			],
		];
	}


	/**
	 *
	 */
	public function actionIndex() {
		$connection = Yii::$app->db;
		$items = $this->getItems();

                if (\Yii::$app->db->getTableSchema('{{%version_info}}', true) == null) {
                    $sql = "
                        DROP TABLE IF EXISTS `version_info`;
                        CREATE TABLE version_info (
                          revision_version int(11) NOT NULL,
                          comments varchar(255) DEFAULT NULL,
                          PRIMARY KEY (revision_version)
                        )
                        ENGINE = INNODB
                        CHARACTER SET utf8
                        COLLATE utf8_general_ci
                        ROW_FORMAT = DYNAMIC;
                    INSERT INTO version_info (revision_version) VALUES(0);";
                    $connection->createCommand($sql)->execute();
                }

		if (!empty($_REQUEST['rev'])) {
			$rev = intval($_REQUEST['rev']);
		}
		else {
			$rev = $connection->createCommand('select revision_version from version_info')->queryScalar();
		}
		foreach ($items as $item) {
			if ($item['rev'] <= $rev) {
				continue;
			}
			foreach ($item['sqls'] as $sql) {
				set_time_limit(120);
				$connection->createCommand($sql)->execute();
//				print $sql."<br>";
			}
			$connection->createCommand('UPDATE version_info SET revision_version = ' . $item['rev'] . '; ')->execute();
			echo "Upgrade to ver." . $item['rev'] . (get_class(Yii::$app) == 'yii\console\Application' ? "\n" : "<br>");
		}
		if (Yii::$app->getCache()) {
			if ( Yii::$app->getCache()->flush() ) {
				echo "Cache flushed successfully." . (get_class(Yii::$app) == 'yii\console\Application' ? "\n" : "<br>");
			}
			else {
				echo "Cache flushed fail." . (get_class(Yii::$app) == 'yii\console\Application' ? "\n" : "<br>");
			}
		}
		print (get_class(Yii::$app) == 'yii\console\Application' ? "\n" : "<br>") . "Upgrade successfully completed";
	}


	/**
	 *
	 */
	public static function checkUpdateDB() {
		$arr = self::getItems();
		$last = end($arr);
		$connection = Yii::$app->db;
		$rev = $connection->createCommand('select revision_version from version_info')->queryScalar();
		return $rev < $last['rev'];
	}


	/**
	 *
	 */
	protected static function getItems() {
		$items = array(
			array(
				'rev' => 1,
				'sqls' => array(
					"
                                        CREATE TABLE `access_token` (
                                        `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                        `token` varchar(255) COLLATE 'utf8_general_ci' NOT NULL,
                                        `ttl` int NOT NULL,
                                        `id_user` int(11) NOT NULL,
                                        FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
                                      ) ENGINE='InnoDB';

                                        ALTER TABLE `access_token`
                                        CHANGE `created` `created` datetime NOT NULL AFTER `ttl`;
                                            ",


				),
			),
                    array(
                        'rev' => 2,
                        'sqls' => array(
                            "UPDATE `users` SET
                                `status` = '10'
                                WHERE `id` = '2';

                                UPDATE `users` SET
                                `status` = '10'
                                WHERE `id` = '3';

                                UPDATE `users` SET
                                `status` = '10'
                                WHERE `id` = '4';
"

                        ),
                    ),
                    [
                        'rev' => 3,
                        'sqls' => [
                            "
                            ALTER TABLE `parcel`
                            CHANGE `describe` `describe` varchar(255) COLLATE 'utf8mb4_general_ci' NOT NULL AFTER `id_gift`;

                            ALTER TABLE `dates`
                            CHANGE `describe` `describe` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `id_date_desc`;

                            ALTER TABLE `gift`
                            CHANGE `describe` `describe` varchar(255) COLLATE 'utf8mb4_general_ci' NULL AFTER `to`;
                            "
                        ]
                    ],
                    [
                        'rev' => 4,
                        'sqls' => [
                            "
                            ALTER TABLE `dates`
                            COLLATE 'utf8mb4_general_ci';

                            ALTER TABLE `gift`
                            COLLATE 'utf8mb4_general_ci';

                            ALTER TABLE `parcel`
                            COLLATE 'utf8mb4_general_ci';
                            "
                        ]
                    ],
                    [
                        'rev' => 5,
                        'sqls' => [
                            "
                            ALTER TABLE `dates`
                            CHANGE `mem_date` `mem_date` varchar(100) COLLATE 'utf8_general_ci' NOT NULL AFTER `id_gift_reciever`;
                            "
                        ]
                    ],
                    [
                        'rev' => 7,
                        'sqls' => [
                            "
                            ALTER TABLE `gift_reciever`
                            CHANGE `birthday` `birthday` varchar(100) COLLATE 'utf8_general_ci' NOT NULL AFTER `phone`;
                            "
                        ]
                    ],
                    [
                        'rev' => 8,
                        'sqls' => [
                            "
                            ALTER TABLE `dates`
                            CHANGE `mem_date` `mem_date` varchar(100) COLLATE 'utf8_general_ci' NOT NULL AFTER `id_gift_reciever`;
                            "
                        ]
                    ],
                    [
                        'rev' => 10,
                        'sqls' => [
                            "
                            ALTER TABLE `dates`
                            DEFAULT CHARACTER SET utf8mb4 COLLATE
                            utf8mb4_general_ci;

                            ALTER TABLE `gift`
                            DEFAULT CHARACTER SET utf8mb4 COLLATE
                            utf8mb4_general_ci;

                            ALTER TABLE `parcel`
                            DEFAULT CHARACTER SET utf8mb4 COLLATE
                            utf8mb4_general_ci;

                            SET foreign_key_checks = 0;

                            ALTER TABLE `dates`
                            CHANGE `mem_date` `mem_date` date NOT NULL AFTER `id_gift_reciever`;

                            ALTER TABLE `gift_reciever`
                            CHANGE `birthday` `birthday` date NOT NULL AFTER `phone`;
                            "
                        ]
                    ],
                    [
                        'rev' => 11,
        				'sqls' => [
        					'ALTER TABLE `gift_reciever` CHANGE `id_users` `id_user` INT(11) NOT NULL;',
        					'RENAME TABLE `users` TO `user`;'
        				]
                    ],

                    [
                        'rev' => 13,
        				'sqls' => [
        					"ALTER TABLE `dates`
                                ADD `simple_date` date NULL AFTER `id_date_desc`;
                             ALTER TABLE `dates`
                            CHANGE `simple_date` `simple_date` date NULL AFTER `mem_date`,
                            CHANGE `id_date_desc` `id_date_desc` bigint(20) NULL AFTER `simple_date`;
                            ALTER TABLE `dates`
                            CHANGE `simple_date` `simple_date` varchar(30) COLLATE 'utf8mb4_general_ci' NULL AFTER `mem_date`;"
        				]
                    ],
                    [
                        'rev' => 14,
        				'sqls' => [
        					"ALTER TABLE `dates`
                            ADD `date_m` varchar(20) COLLATE 'utf8mb4_general_ci' NOT NULL AFTER `mem_date`,
                            ADD `date_d` varchar(20) COLLATE 'utf8mb4_general_ci' NOT NULL AFTER `date_m`,
                            ADD `date_y` varchar(20) COLLATE 'utf8mb4_general_ci' NOT NULL AFTER `date_d`,
                            DROP `simple_date`;

                            ALTER TABLE `dates`
                            CHANGE `mem_date` `mem_date` date NULL AFTER `id_gift_reciever`;

                            ALTER TABLE `dates`
                            DROP `mem_date`;    "
        				]
                    ],
                    [
                        'rev' => 15,
        				'sqls' => [
        					"ALTER TABLE `dates`
                            CHANGE `date_y` `date_y` varchar(20) COLLATE 'utf8mb4_general_ci' NULL AFTER `date_d`;"
        				]
                    ],
                    [
                        'rev' => 16,
        				'sqls' => [
        					"ALTER TABLE `gift_reciever`
                            ADD `describe` text COLLATE 'utf8_general_ci' NOT NULL AFTER `gender`;"
        				]
                    ],
                    [
                        'rev' => 17,
        				'sqls' => [
        					"CREATE TABLE `gift_tag` (
                            `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            `id_gift` bigint(20) NOT NULL,
                            `name` varchar(255) COLLATE 'utf8mb4_general_ci' NOT NULL,
                            FOREIGN KEY (`id_gift`) REFERENCES `gift` (`id`)
                          ) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';

                            ALTER TABLE `gift_tag`
                            ADD INDEX `name` (`name`);"
        				]
                    ],
                    [
                        'rev' => 18,
        				'sqls' => [
        					"CREATE TABLE `tag` (
                            `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            `name` varchar(255) COLLATE 'utf8mb4_general_ci' NOT NULL
                          ) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';

                            ALTER TABLE `tag`
                            ADD INDEX `name` (`name`);

                            ALTER TABLE `gift_tag`
                            ADD `id_tag` bigint(20) NOT NULL AFTER `id_gift`,
                            DROP `name`;"
        				]
                    ],
			[
				'rev' => 19,
				'sqls' => [
					'ALTER TABLE gift
					  DROP FOREIGN KEY gift_ibfk_1;',
					'ALTER TABLE gift
					  ADD CONSTRAINT gift_ibfk_1 FOREIGN KEY (id_dates)
					    REFERENCES dates(id) ON DELETE CASCADE ON UPDATE CASCADE;',
					'ALTER TABLE gift
					  DROP FOREIGN KEY gift_ibfk_2;',
					'ALTER TABLE gift
					  ADD CONSTRAINT gift_ibfk_2 FOREIGN KEY (id_category)
					    REFERENCES category(id) ON DELETE CASCADE ON UPDATE CASCADE;',
					'ALTER TABLE gift
					  DROP FOREIGN KEY gift_ibfk_3;',
					'ALTER TABLE gift
					  ADD CONSTRAINT gift_ibfk_3 FOREIGN KEY (id_product)
					    REFERENCES product(id) ON DELETE CASCADE ON UPDATE CASCADE;',

					'ALTER TABLE dates
					  DROP FOREIGN KEY dates_ibfk_1;',
					'ALTER TABLE dates
					  ADD CONSTRAINT dates_ibfk_1 FOREIGN KEY (id_gift_reciever)
					    REFERENCES gift_reciever(id) ON DELETE CASCADE ON UPDATE CASCADE;',
					'ALTER TABLE dates
					  DROP FOREIGN KEY dates_ibfk_2;',
					'ALTER TABLE dates
					  ADD CONSTRAINT dates_ibfk_2 FOREIGN KEY (id_date_desc)
					    REFERENCES date_desc(id) ON DELETE CASCADE ON UPDATE CASCADE;'
				]
			],
			 [
			 	'rev' => 20,
			 	'sqls' => [
                    "ALTER TABLE `access_token`
                    ADD `created` datetime NOT NULL AFTER `ttl`;"
                ]
			 ],
			[
				'rev' => 21,
				'sqls' => [
					"RENAME TABLE `gift_reciever` TO `gift_receiver`",
					"ALTER TABLE `dates` CHANGE `id_gift_reciever` `id_gift_receiver` BIGINT(20) NOT NULL;",
					"ALTER TABLE `shipping` CHANGE `id_gift_reciever` `id_gift_receiver` BIGINT(20) NOT NULL;"
				]
			],
			[
				'rev' => 22,
				'sqls' => [
					"ALTER TABLE `gift_receiver` ADD `is_approximate_age` BOOLEAN NOT NULL DEFAULT FALSE AFTER `birthday`;"
				]
			],
            [
            'rev' => 23,
            'sqls' => [
                "ALTER TABLE `gift_tag`
                    DROP FOREIGN KEY `gift_tag_ibfk_1`,
                    ADD FOREIGN KEY (`id_gift`) REFERENCES `gift` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
				]
            ],

			[
				'rev' => 24,
				'sqls' => [
					"ALTER TABLE `gift_receiver` ADD `birthday_day` TINYINT(2) NULL AFTER `birthday`;",
					"ALTER TABLE `gift_receiver` ADD `birthday_month` TINYINT(2) NULL AFTER `birthday_day`;",
					"ALTER TABLE `gift_receiver` ADD `birthday_year` SMALLINT(4) NULL AFTER `birthday_month`;",
					"UPDATE `gift_receiver` SET `birthday_day` = DAY(birthday), `birthday_month` = MONTH(birthday), `birthday_year` = YEAR(birthday);"
				]
			],
			[
				'rev' => 25,
				'sqls' => [
					"ALTER TABLE `gift_receiver` CHANGE `birthday` `birthday` DATE NULL;"
				]
			],
			 [
			 	'rev' => 26,
			 	'sqls' => [
					"ALTER TABLE `gift_receiver`
					CHANGE `describe` `describe` text COLLATE 'utf8_general_ci' NULL AFTER `gender`"
			 	]
			 ],
			[
				'rev' => 27,
				'sqls' => [
					"RENAME TABLE `date_desc` TO `holiday`",
					"ALTER TABLE `dates` CHANGE `id_date_desc` `id_holiday` BIGINT(20) NULL DEFAULT NULL;",
				]
			],
			[
				'rev' => 28,
				'sqls' => [
					"ALTER TABLE `dates` CHANGE `describe` `custom_holiday` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;"
				]
			],
			 [
			 	'rev' => 29,
			 	'sqls' => [
					"ALTER TABLE `holiday`
					ADD `day` varchar(20) COLLATE 'utf8_general_ci' NULL,
					ADD `month` varchar(20) COLLATE 'utf8_general_ci' NULL AFTER `day`,
					ADD `is_birthday` tinyint(2) NOT NULL DEFAULT '0' AFTER `month`;"
			 	]
			 ],
			[
				'rev' => 30,
				'sqls' => [
					"ALTER TABLE `dates` CHANGE `date_m` `date_m` TINYINT(2) NOT NULL;",
					"ALTER TABLE `dates` CHANGE `date_d` `date_d` TINYINT(2) NOT NULL;",
				]
			],
			[
				'rev' => 31,
				'sqls' => [
					"ALTER TABLE `gift_receiver` ADD `id_country` BIGINT(20) NULL AFTER `is_active`;",
					"ALTER TABLE `gift_receiver` ADD `id_state` BIGINT(20) NULL AFTER `id_country`;",
					"ALTER TABLE `gift_receiver` ADD `custom_state` VARCHAR(63) NULL AFTER `id_state`;",
					"ALTER TABLE `gift_receiver` ADD `city` VARCHAR(63) NULL AFTER `custom_state`;",
					"ALTER TABLE `gift_receiver` ADD `zip` VARCHAR(10) NULL AFTER `city`;",
					"ALTER TABLE `gift_receiver` ADD `address1` VARCHAR(255) NULL AFTER `zip`;",
					"ALTER TABLE `gift_receiver` ADD `address2` VARCHAR(255) NULL AFTER `address1`;",
					"ALTER TABLE `gift_receiver`
							ADD FOREIGN KEY (`id_country`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;",
					"ALTER TABLE `gift_receiver`
							ADD FOREIGN KEY (`id_state`) REFERENCES `state` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;",
				]
			],
			 [
			 	'rev' => 32,
			 	'sqls' => [
					"CREATE TABLE `relation` (
					`id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`name` varchar(255) COLLATE 'utf8_general_ci' NOT NULL
				  ) ENGINE='InnoDB' COLLATE 'utf8_general_ci';"
			 	]
			 ],
			 [
			 	'rev' => 33,
			 	'sqls' => [
					"ALTER TABLE `relation`
					ADD `is_active` tinyint(2) NOT NULL DEFAULT '1';"
			 	]
			 ],
			 [
			 	'rev' => 34,
			 	'sqls' => [
					"UPDATE `holiday` SET
					`id` = '12',
					`name` = 'Birthday',
					`day` = '',
					`month` = '',
					`is_birthday` = '1'
					WHERE `id` = '12';"
			 	]
			 ],
			[
				'rev' => 35,
				'sqls' => [
					"ALTER TABLE `gift_receiver` ADD `address_type` TINYINT(1) NOT NULL DEFAULT 1 AFTER `is_active`;",
					"UPDATE `gift_receiver` SET `address_type`=1,`id_country`=211,`id_state`=1,`city`='Anchorage',`zip`='99501', `address1` = id",
					"SET FOREIGN_KEY_CHECKS = 0;ALTER TABLE `gift_receiver` CHANGE `id_country` `id_country` BIGINT(20) NOT NULL;SET FOREIGN_KEY_CHECKS = 1;",
					"ALTER TABLE `gift_receiver` CHANGE `city` `city` VARCHAR(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
					"ALTER TABLE `gift_receiver` CHANGE `address1` `address1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",
				]
			],
			[
				'rev' => 36,
				'sqls' => [
					"ALTER TABLE `gift_receiver` ADD `id_relation` BIGINT(20) NULL AFTER `is_active`;",
					"ALTER TABLE `gift_receiver`
						ADD FOREIGN KEY (`id_relation`) REFERENCES `relation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;",
				]
			],
			[
				'rev' => 37,
				'sqls' => [
					"ALTER TABLE `holiday`
					  DROP `day`,
					  DROP `month`;",
					"ALTER TABLE `holiday` ADD `strtotime` VARCHAR(255) NULL AFTER `name`;"
				]
			],
			// [
			// 	'rev' => #,
			// 	'sqls' => [
			// 	]
			// ],
		);
		return $items;
	}

}
