<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611102511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C7ADA1FB5 FOREIGN KEY (color_id) REFERENCES colors_status (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B00651C7ADA1FB5 ON status (color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C7ADA1FB5');
        $this->addSql('DROP INDEX UNIQ_7B00651C7ADA1FB5 ON status');
        $this->addSql('ALTER TABLE status DROP color_id');
    }
}
