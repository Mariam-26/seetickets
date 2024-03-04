<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304132834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, category_event_id INT DEFAULT NULL, event_name VARCHAR(255) NOT NULL, event_place VARCHAR(255) NOT NULL, organisation_name VARCHAR(255) NOT NULL, event_image VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7C68D6CF0 (category_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programmation (id INT AUTO_INCREMENT NOT NULL, event_programmation_id INT DEFAULT NULL, programmation_date DATETIME NOT NULL, INDEX IDX_5E9F80E3B0C65EC1 (event_programmation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, programmation_ticket_id INT DEFAULT NULL, user_ticket_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, ticket_date DATETIME NOT NULL, ticket_firstname VARCHAR(255) NOT NULL, ticket_lastname VARCHAR(255) NOT NULL, ticket_time DATETIME NOT NULL, ticket_place VARCHAR(255) NOT NULL, ticket_nuber_place VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA32566445 (programmation_ticket_id), INDEX IDX_97A0ADA370E0CA36 (user_ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, user_lastname VARCHAR(255) NOT NULL, user_firstname VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_actived TINYINT(1) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C68D6CF0 FOREIGN KEY (category_event_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE programmation ADD CONSTRAINT FK_5E9F80E3B0C65EC1 FOREIGN KEY (event_programmation_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA32566445 FOREIGN KEY (programmation_ticket_id) REFERENCES programmation (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA370E0CA36 FOREIGN KEY (user_ticket_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C68D6CF0');
        $this->addSql('ALTER TABLE programmation DROP FOREIGN KEY FK_5E9F80E3B0C65EC1');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA32566445');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA370E0CA36');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE programmation');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
