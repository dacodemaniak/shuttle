<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116202405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE auth_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9315F04EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, shuttle_id INT NOT NULL, customer_id INT NOT NULL, places INT NOT NULL, INDEX IDX_E00CEDDEBC51D015 (shuttle_id), INDEX IDX_E00CEDDE9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(75) NOT NULL, first_name VARCHAR(75) DEFAULT NULL, email VARCHAR(150) NOT NULL, wished_places SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shuttle (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        //$this->addSql('ALTER TABLE auth_token ADD CONSTRAINT FK_9315F04EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEBC51D015 FOREIGN KEY (shuttle_id) REFERENCES shuttle (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9395C3F3');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEBC51D015');
        //$this->addSql('ALTER TABLE auth_token DROP FOREIGN KEY FK_9315F04EA76ED395');
        //$this->addSql('DROP TABLE auth_token');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE shuttle');
        $this->addSql('DROP TABLE user');
    }
}
