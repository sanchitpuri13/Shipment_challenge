<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926144406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, carrier_id INT NOT NULL, shipment_id INT NOT NULL, distance_in_meters INT NOT NULL, distance_in_km DOUBLE PRECISION NOT NULL, shipment_time DOUBLE PRECISION NOT NULL, cost DOUBLE PRECISION NOT NULL, origin_stop_id INT NOT NULL, origin_postcode VARCHAR(12) NOT NULL, origin_city VARCHAR(90) NOT NULL, origin_country VARCHAR(2) NOT NULL, destination_stop_id INT NOT NULL, destination_postcode VARCHAR(12) NOT NULL, destination_city VARCHAR(90) NOT NULL, destination_country VARCHAR(2) NOT NULL, INDEX IDX_2CB20DC979B1AD6 (company_id), INDEX IDX_2CB20DC21DFC797 (carrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DC979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DC21DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC979B1AD6');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC21DFC797');
        $this->addSql('DROP TABLE shipment');
    }
}
