<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312101109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT IGNORE INTO `sensor_value_type` (`id`, `name`, `type`, `round_digits`, `max_possible_value`) 
            VALUES
            (1, 'pm25', 'pm25', 1, 500.4),
            (2, 'pm100', 'pm100', 0, 604),
            (3, 'o31', 'o31', 3, 0.604),
            (4, 'o38', 'o38', 3, 0.2),
            (5, 'co', 'co', 1, 50.4),
            (6, 'so2', 'so2', 0, 1004),
            (7, 'no2', 'no2', 0, 2049);
        ");

        $this->addSql("INSERT IGNORE INTO `sensor_value_breakpoints` 
          (`id`, `sensor_value_type_id`, `value_min`, `value_max`, `aqi_min`, `aqi_max`) VALUES
          (1, 4, 0, 0.054, 0, 50),
          (2, 4, 0.055, 0.07, 51, 100),
          (3, 4, 0.071, 0.085, 101, 150),
          (4, 4, 0.086, 0.105, 151, 200),
          (5, 3, 0.125, 0.164, 101, 150),
          (6, 3, 0.165, 0.204, 151, 200),
          (7, 3, 0.205, 0.404, 201, 300),
          (8, 3, 0.405, 0.504, 301, 400),
          (9, 3, 0.505, 0.604, 401, 500),
          (10, 1, 0, 12, 0, 50),
          (11, 1, 12.1, 35.4, 51, 100),
          (12, 1, 35.5, 55.4, 101, 150),
          (13, 1, 55.5, 150.4, 151, 200),
          (14, 1, 150.5, 250.4, 201, 300),
          (15, 1, 250.5, 350.4, 301, 400),
          (16, 1, 350.5, 500.4, 401, 500),
          (17, 2, 0, 54, 0, 50),
          (18, 2, 55, 154, 51, 100),
          (19, 2, 155, 254, 101, 150),
          (20, 2, 255, 354, 151, 200),
          (21, 2, 355, 424, 201, 300),
          (22, 2, 425, 504, 301, 400),
          (23, 2, 505, 604, 401, 500),
          (24, 5, 0, 4.4, 0, 50),
          (25, 5, 4.5, 9.4, 51, 100),
          (26, 5, 9.5, 12.4, 101, 150),
          (27, 5, 12.5, 15.4, 151, 200),
          (28, 5, 15.5, 30.4, 201, 300),
          (29, 5, 30.5, 40.4, 301, 400),
          (30, 5, 40.5, 50.4, 401, 500),
          (31, 6, 0, 35, 0, 50),
          (32, 6, 36, 75, 51, 100),
          (33, 6, 76, 185, 101, 150),
          (34, 6, 186, 304, 151, 200),
          (35, 6, 305, 604, 201, 300),
          (36, 6, 605, 804, 301, 400),
          (37, 6, 805, 1004, 401, 500),
          (38, 7, 0, 53, 0, 50),
          (39, 7, 54, 100, 51, 100),
          (40, 7, 101, 360, 101, 150),
          (41, 7, 361, 649, 151, 200),
          (42, 7, 650, 1249, 201, 300),
          (43, 7, 1250, 1649, 301, 400),
          (44, 7, 1650, 2049, 401, 500);
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
