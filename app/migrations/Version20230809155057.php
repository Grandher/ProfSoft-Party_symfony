<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809155057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE guest_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE receipt_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE guest (id INT NOT NULL, author_id INT DEFAULT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ACB79A35F675F31B ON guest (author_id)');
        $this->addSql('CREATE INDEX IDX_ACB79A3519EB6921 ON guest (client_id)');
        $this->addSql('CREATE TABLE guest_product (guest_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(guest_id, product_id))');
        $this->addSql('CREATE INDEX IDX_938FC0E19A4AA658 ON guest_product (guest_id)');
        $this->addSql('CREATE INDEX IDX_938FC0E14584665A ON guest_product (product_id)');
        $this->addSql('CREATE TABLE payment (id INT NOT NULL, guest_declared_id INT DEFAULT NULL, guest_received_id INT DEFAULT NULL, author_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840DCE6647A5 ON payment (guest_declared_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D3F145E77 ON payment (guest_received_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF675F31B ON payment (author_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, receipt_id INT DEFAULT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD2B5CA896 ON product (receipt_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
        $this->addSql('CREATE TABLE receipt (id INT NOT NULL, guest_id INT NOT NULL, author_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, store VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5399B6459A4AA658 ON receipt (guest_id)');
        $this->addSql('CREATE INDEX IDX_5399B645F675F31B ON receipt (author_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A3519EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E19A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCE6647A5 FOREIGN KEY (guest_declared_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D3F145E77 FOREIGN KEY (guest_received_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6459A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B645F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE guest_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE receipt_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A35F675F31B');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A3519EB6921');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E19A4AA658');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E14584665A');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DCE6647A5');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D3F145E77');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DF675F31B');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD2B5CA896');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADF675F31B');
        $this->addSql('ALTER TABLE receipt DROP CONSTRAINT FK_5399B6459A4AA658');
        $this->addSql('ALTER TABLE receipt DROP CONSTRAINT FK_5399B645F675F31B');
        $this->addSql('DROP TABLE guest');
        $this->addSql('DROP TABLE guest_product');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE "user"');
    }
}
