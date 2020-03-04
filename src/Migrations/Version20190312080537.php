<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312080537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sensor_value_breakpoints (id INT AUTO_INCREMENT NOT NULL, sensor_value_type_id INT NOT NULL, value_min DOUBLE PRECISION NOT NULL, value_max DOUBLE PRECISION NOT NULL, aqi_min INT NOT NULL, aqi_max INT NOT NULL, INDEX IDX_A85B0D29BA04944D (sensor_value_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sensor_value_breakpoints ADD CONSTRAINT FK_A85B0D29BA04944D FOREIGN KEY (sensor_value_type_id) REFERENCES sensor_value_type (id)');
        // $this->addSql('DROP TABLE tmp');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('CREATE TABLE tmp (id INT AUTO_INCREMENT NOT NULL, min DOUBLE PRECISION DEFAULT NULL, max DOUBLE PRECISION DEFAULT NULL, aqi_min INT DEFAULT NULL, aqi_max INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE sensor_value_breakpoints');
    }
}
