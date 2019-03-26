<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325134341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE aqi (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, aqi INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aqi_sensor_record (aqi_id INT NOT NULL, sensor_record_id INT NOT NULL, INDEX IDX_33A6959C69F61088 (aqi_id), INDEX IDX_33A6959C34B7D919 (sensor_record_id), PRIMARY KEY(aqi_id, sensor_record_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aqi_sensor_record ADD CONSTRAINT FK_33A6959C69F61088 FOREIGN KEY (aqi_id) REFERENCES aqi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aqi_sensor_record ADD CONSTRAINT FK_33A6959C34B7D919 FOREIGN KEY (sensor_record_id) REFERENCES sensor_record (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE aqi_sensor_record DROP FOREIGN KEY FK_33A6959C69F61088');
        $this->addSql('DROP TABLE aqi');
        $this->addSql('DROP TABLE aqi_sensor_record');
    }
}
