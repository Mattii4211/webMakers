<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925073409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budgets (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, balance NUMERIC(15, 2) NOT NULL, createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contractors (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', contractor_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', number VARCHAR(255) NOT NULL, amount NUMERIC(15, 2) NOT NULL, paid TINYINT(1) NOT NULL, dueDate DATETIME NOT NULL, createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_6A2F2F9596901F54 (number), INDEX IDX_6A2F2F95B0265DC7 (contractor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warnings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', objectType VARCHAR(255) NOT NULL, objectId VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F95B0265DC7 FOREIGN KEY (contractor_id) REFERENCES contractors (id)');
        $this->addSql('CREATE UNIQUE INDEX unique_object_type_id ON warnings (objectType, objectId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F95B0265DC7');
        $this->addSql('DROP TABLE budgets');
        $this->addSql('DROP TABLE contractors');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP INDEX unique_object_type_id ON warnings');
        $this->addSql('DROP TABLE warnings');
    }
}
