<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129225237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, answer VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guess (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, answer_id INT NOT NULL, guesser VARCHAR(255) NOT NULL, INDEX IDX_32D30F961E27F6BF (question_id), INDEX IDX_32D30F96AA334807 (answer_id), UNIQUE INDEX UNIQ_32D30F9650FC9FD31E27F6BF (guesser, question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, right_answer_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B6F7494E4C827E5E (right_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wrong_answer (id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_5DA89B971E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F961E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F96AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E4C827E5E FOREIGN KEY (right_answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE wrong_answer ADD CONSTRAINT FK_5DA89B971E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE wrong_answer ADD CONSTRAINT FK_5DA89B97BF396750 FOREIGN KEY (id) REFERENCES answer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guess DROP FOREIGN KEY FK_32D30F961E27F6BF');
        $this->addSql('ALTER TABLE guess DROP FOREIGN KEY FK_32D30F96AA334807');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E4C827E5E');
        $this->addSql('ALTER TABLE wrong_answer DROP FOREIGN KEY FK_5DA89B971E27F6BF');
        $this->addSql('ALTER TABLE wrong_answer DROP FOREIGN KEY FK_5DA89B97BF396750');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE guess');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE wrong_answer');
    }
}
