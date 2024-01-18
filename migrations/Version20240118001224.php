<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118001224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE guess_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, question_id INT NOT NULL, answer VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE TABLE guess (id INT NOT NULL, question_id INT NOT NULL, answer_id INT NOT NULL, guesser VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32D30F961E27F6BF ON guess (question_id)');
        $this->addSql('CREATE INDEX IDX_32D30F96AA334807 ON guess (answer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32D30F9650FC9FD31E27F6BF ON guess (guesser, question_id)');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, right_answer_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6F7494E4C827E5E ON question (right_answer_id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F961E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F96AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E4C827E5E FOREIGN KEY (right_answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE guess_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE guess DROP CONSTRAINT FK_32D30F961E27F6BF');
        $this->addSql('ALTER TABLE guess DROP CONSTRAINT FK_32D30F96AA334807');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494E4C827E5E');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE guess');
        $this->addSql('DROP TABLE question');
    }
}
