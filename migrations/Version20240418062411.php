<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418062411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results ADD result_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414EEB0C9DB FOREIGN KEY (result_id_id) REFERENCES student_profile (id)');
        $this->addSql('CREATE INDEX IDX_9FA3E414EEB0C9DB ON results (result_id_id)');
        $this->addSql('ALTER TABLE student_profile ADD CONSTRAINT FK_6C611FF71BB98D52 FOREIGN KEY (student_email_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6C611FF71BB98D52 ON student_profile (student_email_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results DROP FOREIGN KEY FK_9FA3E414EEB0C9DB');
        $this->addSql('DROP INDEX IDX_9FA3E414EEB0C9DB ON results');
        $this->addSql('ALTER TABLE results DROP result_id_id');
        $this->addSql('ALTER TABLE student_profile DROP FOREIGN KEY FK_6C611FF71BB98D52');
        $this->addSql('DROP INDEX UNIQ_6C611FF71BB98D52 ON student_profile');
    }
}
