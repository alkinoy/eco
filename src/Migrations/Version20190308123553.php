<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190308123553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sensor_value (id INT AUTO_INCREMENT NOT NULL, record_id INT NOT NULL, value_type_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5B3302DC4DFD750C (record_id), INDEX IDX_5B3302DC2EEEF9F3 (value_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor_value_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor_record (id INT AUTO_INCREMENT NOT NULL, sensor_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_35A3B181A247991F (sensor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sensor_value ADD CONSTRAINT FK_5B3302DC4DFD750C FOREIGN KEY (record_id) REFERENCES sensor_record (id)');
        $this->addSql('ALTER TABLE sensor_value ADD CONSTRAINT FK_5B3302DC2EEEF9F3 FOREIGN KEY (value_type_id) REFERENCES sensor_value_type (id)');
        $this->addSql('ALTER TABLE sensor_record ADD CONSTRAINT FK_35A3B181A247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sensor_value DROP FOREIGN KEY FK_5B3302DC2EEEF9F3');
        $this->addSql('ALTER TABLE sensor_record DROP FOREIGN KEY FK_35A3B181A247991F');
        $this->addSql('ALTER TABLE sensor_value DROP FOREIGN KEY FK_5B3302DC4DFD750C');
        $this->addSql('DROP TABLE sensor_value');
        $this->addSql('DROP TABLE sensor_value_type');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE sensor_record');
    }
}
