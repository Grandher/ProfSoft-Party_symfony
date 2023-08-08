<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731190716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guest_product (guest_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(guest_id, product_id))');
        $this->addSql('CREATE INDEX IDX_938FC0E19A4AA658 ON guest_product (guest_id)');
        $this->addSql('CREATE INDEX IDX_938FC0E14584665A ON guest_product (product_id)');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E19A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD guest_declared_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD guest_received_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCE6647A5 FOREIGN KEY (guest_declared_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D3F145E77 FOREIGN KEY (guest_received_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840DCE6647A5 ON payment (guest_declared_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D3F145E77 ON payment (guest_received_id)');
        $this->addSql('ALTER TABLE product ADD receipt_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04AD2B5CA896 ON product (receipt_id)');
        $this->addSql('ALTER TABLE receipt ADD guest_id INT NOT NULL');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6459A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5399B6459A4AA658 ON receipt (guest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E19A4AA658');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E14584665A');
        $this->addSql('DROP TABLE guest_product');
        $this->addSql('ALTER TABLE receipt DROP CONSTRAINT FK_5399B6459A4AA658');
        $this->addSql('DROP INDEX IDX_5399B6459A4AA658');
        $this->addSql('ALTER TABLE receipt DROP guest_id');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DCE6647A5');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D3F145E77');
        $this->addSql('DROP INDEX IDX_6D28840DCE6647A5');
        $this->addSql('DROP INDEX IDX_6D28840D3F145E77');
        $this->addSql('ALTER TABLE payment DROP guest_declared_id');
        $this->addSql('ALTER TABLE payment DROP guest_received_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD2B5CA896');
        $this->addSql('DROP INDEX IDX_D34A04AD2B5CA896');
        $this->addSql('ALTER TABLE product DROP receipt_id');
    }
}
