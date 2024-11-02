<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102124336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(100) NOT NULL, zip_code VARCHAR(50) NOT NULL, country VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE car_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_C3F97C8F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, registration_number VARCHAR(255) NOT NULL, vin VARCHAR(17) NOT NULL, client_email VARCHAR(100) NOT NULL, is_rented TINYINT(1) NOT NULL, brand_id INT NOT NULL, client_address_id INT DEFAULT NULL, current_location_id INT DEFAULT NULL, INDEX IDX_1B80E48644F5D008 (brand_id), INDEX IDX_1B80E48665E39234 (client_address_id), INDEX IDX_1B80E486B8998A57 (current_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48644F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48665E39234 FOREIGN KEY (client_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486B8998A57 FOREIGN KEY (current_location_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48644F5D008');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48665E39234');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486B8998A57');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE car_brand');
        $this->addSql('DROP TABLE vehicle');
    }
}
