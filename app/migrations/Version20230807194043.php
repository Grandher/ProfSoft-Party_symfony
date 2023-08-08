<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807194043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guest ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A3519EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_ACB79A35F675F31B ON guest (author_id)');
        $this->addSql('CREATE INDEX IDX_ACB79A3519EB6921 ON guest (client_id)');
        $this->addSql('ALTER TABLE payment ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840DF675F31B ON payment (author_id)');
        $this->addSql('ALTER TABLE product ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
        $this->addSql('ALTER TABLE receipt ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B645F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5399B645F675F31B ON receipt (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE receipt DROP CONSTRAINT FK_5399B645F675F31B');
        $this->addSql('DROP INDEX IDX_5399B645F675F31B');
        $this->addSql('ALTER TABLE receipt DROP author_id');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A35F675F31B');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A3519EB6921');
        $this->addSql('DROP INDEX IDX_ACB79A35F675F31B');
        $this->addSql('DROP INDEX IDX_ACB79A3519EB6921');
        $this->addSql('ALTER TABLE guest DROP author_id');
        $this->addSql('ALTER TABLE guest DROP client_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADF675F31B');
        $this->addSql('DROP INDEX IDX_D34A04ADF675F31B');
        $this->addSql('ALTER TABLE product DROP author_id');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DF675F31B');
        $this->addSql('DROP INDEX IDX_6D28840DF675F31B');
        $this->addSql('ALTER TABLE payment DROP author_id');
    }
}
