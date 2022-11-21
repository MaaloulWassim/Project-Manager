<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209001310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, tmaker_id INT DEFAULT NULL, project_tasks_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, task_statue TINYINT(1) NOT NULL, INDEX IDX_5058659746BE07DD (tmaker_id), INDEX IDX_50586597DE69A6EA (project_tasks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659746BE07DD FOREIGN KEY (tmaker_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597DE69A6EA FOREIGN KEY (project_tasks_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tasks');
    }
}
