<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918070431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, profile_pic VARCHAR(255) NOT NULL, dob DATE NOT NULL, description LONGTEXT NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_num VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, search_range INT NOT NULL, gender VARCHAR(255) NOT NULL, height INT NOT NULL, weight INT NOT NULL, ethnicity VARCHAR(255) NOT NULL, hair VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relation_request (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, date_sent DATETIME NOT NULL, is_aceppted TINYINT(1) NOT NULL, INDEX IDX_22EC9DEEF624B39D (sender_id), INDEX IDX_22EC9DEECD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, conversation_id INT NOT NULL, content LONGTEXT NOT NULL, date_sent DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F9AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_relation (id INT AUTO_INCREMENT NOT NULL, user_a_id INT NOT NULL, user_b_id INT NOT NULL, INDEX IDX_8204A349415F1F91 (user_a_id), INDEX IDX_8204A34953EAB07F (user_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, user_a_id INT NOT NULL, user_b_id INT NOT NULL, save_messages TINYINT(1) NOT NULL, INDEX IDX_8A8E26E9415F1F91 (user_a_id), INDEX IDX_8A8E26E953EAB07F (user_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE relation_request ADD CONSTRAINT FK_22EC9DEEF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE relation_request ADD CONSTRAINT FK_22EC9DEECD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE user_relation ADD CONSTRAINT FK_8204A349415F1F91 FOREIGN KEY (user_a_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_relation ADD CONSTRAINT FK_8204A34953EAB07F FOREIGN KEY (user_b_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9415F1F91 FOREIGN KEY (user_a_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E953EAB07F FOREIGN KEY (user_b_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE relation_request DROP FOREIGN KEY FK_22EC9DEEF624B39D');
        $this->addSql('ALTER TABLE relation_request DROP FOREIGN KEY FK_22EC9DEECD53EDB6');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE user_relation DROP FOREIGN KEY FK_8204A349415F1F91');
        $this->addSql('ALTER TABLE user_relation DROP FOREIGN KEY FK_8204A34953EAB07F');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9415F1F91');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E953EAB07F');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE relation_request');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE user_relation');
        $this->addSql('DROP TABLE conversation');
    }
}
