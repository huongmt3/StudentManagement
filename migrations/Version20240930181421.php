<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930181421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_asm_details (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, assignment_id INT NOT NULL, INDEX IDX_FE2398E1CB944F1A (student_id), INDEX IDX_FE2398E1D19302F8 (assignment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_course_details (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_6D072CDD591CC992 (course_id), INDEX IDX_6D072CDDCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_asm_details ADD CONSTRAINT FK_FE2398E1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_asm_details ADD CONSTRAINT FK_FE2398E1D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id)');
        $this->addSql('ALTER TABLE student_course_details ADD CONSTRAINT FK_6D072CDD591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE student_course_details ADD CONSTRAINT FK_6D072CDDCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE assignment ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_30C544BA591CC992 ON assignment (course_id)');
        $this->addSql('ALTER TABLE course ADD lecturer_id INT DEFAULT NULL, CHANGE end_data end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9BA2D8762 ON course (lecturer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_asm_details DROP FOREIGN KEY FK_FE2398E1CB944F1A');
        $this->addSql('ALTER TABLE student_asm_details DROP FOREIGN KEY FK_FE2398E1D19302F8');
        $this->addSql('ALTER TABLE student_course_details DROP FOREIGN KEY FK_6D072CDD591CC992');
        $this->addSql('ALTER TABLE student_course_details DROP FOREIGN KEY FK_6D072CDDCB944F1A');
        $this->addSql('DROP TABLE student_asm_details');
        $this->addSql('DROP TABLE student_course_details');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA591CC992');
        $this->addSql('DROP INDEX IDX_30C544BA591CC992 ON assignment');
        $this->addSql('ALTER TABLE assignment DROP course_id');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9BA2D8762');
        $this->addSql('DROP INDEX IDX_169E6FB9BA2D8762 ON course');
        $this->addSql('ALTER TABLE course DROP lecturer_id, CHANGE end_date end_data DATE NOT NULL');
    }
}
