<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005113715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, assignment_name VARCHAR(255) NOT NULL, due_date DATE NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_30C544BA591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, course_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, credits INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_169E6FB9BA2D8762 (lecturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecturer (id INT AUTO_INCREMENT NOT NULL, lecturer_name VARCHAR(255) NOT NULL, lecturer_email VARCHAR(255) NOT NULL, lecturer_specialisation VARCHAR(255) NOT NULL, lecturer_gender VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, student_name VARCHAR(255) NOT NULL, student_email VARCHAR(255) NOT NULL, student_gender VARCHAR(10) NOT NULL, date_of_birth DATE NOT NULL, registration_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_asm_details (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, assignment_id INT NOT NULL, INDEX IDX_FE2398E1CB944F1A (student_id), INDEX IDX_FE2398E1D19302F8 (assignment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_course_details (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, student_id INT DEFAULT NULL, INDEX IDX_6D072CDD591CC992 (course_id), INDEX IDX_6D072CDDCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE student_asm_details ADD CONSTRAINT FK_FE2398E1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_asm_details ADD CONSTRAINT FK_FE2398E1D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id)');
        $this->addSql('ALTER TABLE student_course_details ADD CONSTRAINT FK_6D072CDD591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE student_course_details ADD CONSTRAINT FK_6D072CDDCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA591CC992');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9BA2D8762');
        $this->addSql('ALTER TABLE student_asm_details DROP FOREIGN KEY FK_FE2398E1CB944F1A');
        $this->addSql('ALTER TABLE student_asm_details DROP FOREIGN KEY FK_FE2398E1D19302F8');
        $this->addSql('ALTER TABLE student_course_details DROP FOREIGN KEY FK_6D072CDD591CC992');
        $this->addSql('ALTER TABLE student_course_details DROP FOREIGN KEY FK_6D072CDDCB944F1A');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE lecturer');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_asm_details');
        $this->addSql('DROP TABLE student_course_details');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
