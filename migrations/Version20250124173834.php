<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250124173834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_personality (character_id INT NOT NULL, personality_id INT NOT NULL, INDEX IDX_E5A53A021136BE75 (character_id), INDEX IDX_E5A53A02CF3DE080 (personality_id), PRIMARY KEY(character_id, personality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_personality ADD CONSTRAINT FK_E5A53A021136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_personality ADD CONSTRAINT FK_E5A53A02CF3DE080 FOREIGN KEY (personality_id) REFERENCES personality (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_personality DROP FOREIGN KEY FK_E5A53A021136BE75');
        $this->addSql('ALTER TABLE character_personality DROP FOREIGN KEY FK_E5A53A02CF3DE080');
        $this->addSql('DROP TABLE character_personality');
    }
}
