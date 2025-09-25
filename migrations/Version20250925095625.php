<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925095625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgets CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\'');
        $this->addSql('ALTER TABLE contractors CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\'');
        $this->addSql('ALTER TABLE invoices CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', CHANGE contractor_id contractor_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\'');
        $this->addSql('DROP INDEX unique_object_type_id ON warnings');
        $this->addSql('ALTER TABLE warnings CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgets CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE warnings CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('CREATE UNIQUE INDEX unique_object_type_id ON warnings (objectType, objectId)');
        $this->addSql('ALTER TABLE invoices CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE contractor_id contractor_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE contractors CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }
}
