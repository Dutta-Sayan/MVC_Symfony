<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411102503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, exam_name VARCHAR(50) NOT NULL, exam_number VARCHAR(10) NOT NULL, exam_duration DATETIME NOT NULL, passing_marks INT NOT NULL, created_by VARCHAR(255) NOT NULL, eligibility_marks INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, exam_number VARCHAR(10) NOT NULL, question VARCHAR(255) NOT NULL, option_1 VARCHAR(255) NOT NULL, option_2 VARCHAR(255) NOT NULL, option_3 VARCHAR(255) NOT NULL, correct_answer VARCHAR(255) NOT NULL, marks INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE results (id INT AUTO_INCREMENT NOT NULL, student_roll INT DEFAULT NULL, exam_number VARCHAR(10) DEFAULT NULL, marks INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_profile (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, age INT NOT NULL, roll_no INT NOT NULL, graduation_year INT NOT NULL, academic_marks INT NOT NULL, link_to_resume VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE results');
        $this->addSql('DROP TABLE student_profile');
    }
}
