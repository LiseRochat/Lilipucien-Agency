<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609144938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC38612469DE2');
        $this->addSql('DROP INDEX IDX_45EDC38612469DE2 ON bien');
        $this->addSql('ALTER TABLE bien CHANGE category_id status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC3866BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_45EDC3866BF700BD ON bien (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC3866BF700BD');
        $this->addSql('DROP INDEX IDX_45EDC3866BF700BD ON bien');
        $this->addSql('ALTER TABLE bien CHANGE status_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC38612469DE2 FOREIGN KEY (category_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_45EDC38612469DE2 ON bien (category_id)');
    }
}
