<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007080248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_alert (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_B7D7BD3BA76ED395 (user_id), INDEX IDX_B7D7BD3BC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alert_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_36E85AD5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE context (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E25D857E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE descriptor (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_39276025585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, framework_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_A7A91E0B37AECF72 (framework_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, framework_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, hierarchy INT DEFAULT 0 NOT NULL, INDEX IDX_9AEACC1337AECF72 (framework_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, validation_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF675F31B (author_id), INDEX IDX_B6BD307FA2274850 (validation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, skill_id INT NOT NULL, initial_level_id INT NOT NULL, step_id INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) DEFAULT 1 NOT NULL, desactivated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DD5A5B7DA76ED395 (user_id), INDEX IDX_DD5A5B7D5585C142 (skill_id), INDEX IDX_DD5A5B7D87081217 (initial_level_id), INDEX IDX_DD5A5B7D73B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_step (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, step_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_step_domain (plan_step_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_7E0E0B1ACD0D5694 (plan_step_id), INDEX IDX_7E0E0B1A115F0EE5 (domain_id), PRIMARY KEY(plan_step_id, domain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_frame_id INT NOT NULL, INDEX IDX_2FB3D0EEA76ED395 (user_id), INDEX IDX_2FB3D0EE2ED489C (project_frame_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_frame (id INT AUTO_INCREMENT NOT NULL, manager_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, starting_at DATE NOT NULL, ending_at DATE DEFAULT NULL, INDEX IDX_A6AD3553783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_frame_skill (project_frame_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_552AA54E2ED489C (project_frame_id), INDEX IDX_552AA54E5585C142 (skill_id), PRIMARY KEY(project_frame_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, structure_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_694309E42534008B (structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE situation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, starting_at DATE NOT NULL, ending_at DATE DEFAULT NULL, INDEX IDX_EC2D9ACAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, domain_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_5E3DE477115F0EE5 (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_framework (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_CE8755445E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_framework_structure (skill_framework_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_48D55D01A5C25F70 (skill_framework_id), INDEX IDX_48D55D012534008B (structure_id), PRIMARY KEY(skill_framework_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT \'default.webp\' NOT NULL, logo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6F0137EA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tracker (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AC632AAFA76ED395 (user_id), INDEX IDX_AC632AAF5585C142 (skill_id), INDEX IDX_AC632AAF5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, profession VARCHAR(255) NOT NULL, enterprise VARCHAR(255) NOT NULL, starting_at DATE NOT NULL, ending_at DATE NOT NULL, INDEX IDX_D5128A8FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, referent_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', started_at DATE DEFAULT NULL, archived_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) DEFAULT 0 NOT NULL, is_plan_locked TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_8D93D649F6BD1646 (site_id), INDEX IDX_8D93D64935E47E35 (referent_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, context_id INT DEFAULT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, situation_id INT DEFAULT NULL, training_id INT DEFAULT NULL, project_id INT DEFAULT NULL, is_goal TINYINT(1) DEFAULT 0 NOT NULL, is_ref_alert TINYINT(1) DEFAULT 1 NOT NULL, is_user_alert TINYINT(1) DEFAULT 0 NOT NULL, is_validated TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', validated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16AC5B6EA76ED395 (user_id), INDEX IDX_16AC5B6E6B00C1CF (context_id), INDEX IDX_16AC5B6E5585C142 (skill_id), INDEX IDX_16AC5B6E5FB14BA7 (level_id), INDEX IDX_16AC5B6E3408E8AF (situation_id), INDEX IDX_16AC5B6EBEFD98D1 (training_id), INDEX IDX_16AC5B6E166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_alert ADD CONSTRAINT FK_B7D7BD3BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE admin_alert ADD CONSTRAINT FK_B7D7BD3BC54C8C93 FOREIGN KEY (type_id) REFERENCES alert_type (id)');
        $this->addSql('ALTER TABLE descriptor ADD CONSTRAINT FK_39276025585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE domain ADD CONSTRAINT FK_A7A91E0B37AECF72 FOREIGN KEY (framework_id) REFERENCES skill_framework (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC1337AECF72 FOREIGN KEY (framework_id) REFERENCES skill_framework (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA2274850 FOREIGN KEY (validation_id) REFERENCES validation (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D87081217 FOREIGN KEY (initial_level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D73B21E9C FOREIGN KEY (step_id) REFERENCES plan_step (id)');
        $this->addSql('ALTER TABLE plan_step_domain ADD CONSTRAINT FK_7E0E0B1ACD0D5694 FOREIGN KEY (plan_step_id) REFERENCES plan_step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_step_domain ADD CONSTRAINT FK_7E0E0B1A115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE2ED489C FOREIGN KEY (project_frame_id) REFERENCES project_frame (id)');
        $this->addSql('ALTER TABLE project_frame ADD CONSTRAINT FK_A6AD3553783E3463 FOREIGN KEY (manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_frame_skill ADD CONSTRAINT FK_552AA54E2ED489C FOREIGN KEY (project_frame_id) REFERENCES project_frame (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_frame_skill ADD CONSTRAINT FK_552AA54E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E42534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE situation ADD CONSTRAINT FK_EC2D9ACAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('ALTER TABLE skill_framework_structure ADD CONSTRAINT FK_48D55D01A5C25F70 FOREIGN KEY (skill_framework_id) REFERENCES skill_framework (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_framework_structure ADD CONSTRAINT FK_48D55D012534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAF5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAF5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64935E47E35 FOREIGN KEY (referent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E6B00C1CF FOREIGN KEY (context_id) REFERENCES context (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E3408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6EBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_alert DROP FOREIGN KEY FK_B7D7BD3BA76ED395');
        $this->addSql('ALTER TABLE admin_alert DROP FOREIGN KEY FK_B7D7BD3BC54C8C93');
        $this->addSql('ALTER TABLE descriptor DROP FOREIGN KEY FK_39276025585C142');
        $this->addSql('ALTER TABLE domain DROP FOREIGN KEY FK_A7A91E0B37AECF72');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC1337AECF72');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF675F31B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA2274850');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DA76ED395');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D5585C142');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D87081217');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D73B21E9C');
        $this->addSql('ALTER TABLE plan_step_domain DROP FOREIGN KEY FK_7E0E0B1ACD0D5694');
        $this->addSql('ALTER TABLE plan_step_domain DROP FOREIGN KEY FK_7E0E0B1A115F0EE5');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE2ED489C');
        $this->addSql('ALTER TABLE project_frame DROP FOREIGN KEY FK_A6AD3553783E3463');
        $this->addSql('ALTER TABLE project_frame_skill DROP FOREIGN KEY FK_552AA54E2ED489C');
        $this->addSql('ALTER TABLE project_frame_skill DROP FOREIGN KEY FK_552AA54E5585C142');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E42534008B');
        $this->addSql('ALTER TABLE situation DROP FOREIGN KEY FK_EC2D9ACAA76ED395');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477115F0EE5');
        $this->addSql('ALTER TABLE skill_framework_structure DROP FOREIGN KEY FK_48D55D01A5C25F70');
        $this->addSql('ALTER TABLE skill_framework_structure DROP FOREIGN KEY FK_48D55D012534008B');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAFA76ED395');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAF5585C142');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAF5FB14BA7');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F6BD1646');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64935E47E35');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6EA76ED395');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E6B00C1CF');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E5585C142');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E5FB14BA7');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E3408E8AF');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6EBEFD98D1');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E166D1F9C');
        $this->addSql('DROP TABLE admin_alert');
        $this->addSql('DROP TABLE alert_type');
        $this->addSql('DROP TABLE context');
        $this->addSql('DROP TABLE descriptor');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE plan_step');
        $this->addSql('DROP TABLE plan_step_domain');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_frame');
        $this->addSql('DROP TABLE project_frame_skill');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE situation');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_framework');
        $this->addSql('DROP TABLE skill_framework_structure');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE tracker');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE validation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
