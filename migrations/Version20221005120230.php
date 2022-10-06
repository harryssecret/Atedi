<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005120230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_action (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_billing_line (id INT AUTO_INCREMENT NOT NULL, intervention_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_5035F0A78EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_booklet (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_client (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_equipment (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_intervention (id INT AUTO_INCREMENT NOT NULL, operating_system_id INT NOT NULL, equipment_id INT NOT NULL, client_id INT NOT NULL, intervention_report_id INT NOT NULL, deposit_date DATETIME NOT NULL, return_date DATETIME DEFAULT NULL, comment LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, equipment_complete VARCHAR(255) NOT NULL, total_price VARCHAR(255) NOT NULL, INDEX IDX_2F4B6E3DA391D4AD (operating_system_id), INDEX IDX_2F4B6E3D517FE9FE (equipment_id), INDEX IDX_2F4B6E3D19EB6921 (client_id), UNIQUE INDEX UNIQ_2F4B6E3D430C5E9 (intervention_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_task (intervention_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_5DC1C3E78EAE3863 (intervention_id), INDEX IDX_5DC1C3E78DB60186 (task_id), PRIMARY KEY(intervention_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_intervention_report (id INT AUTO_INCREMENT NOT NULL, comment LONGTEXT DEFAULT NULL, step INT NOT NULL, severity VARCHAR(255) DEFAULT NULL, windows_install LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', severity_problem LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', internal_analysis VARCHAR(255) DEFAULT NULL, windows_version VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_report_booklet (intervention_report_id INT NOT NULL, booklet_id INT NOT NULL, INDEX IDX_73D84037430C5E9 (intervention_report_id), INDEX IDX_73D84037668144B3 (booklet_id), PRIMARY KEY(intervention_report_id, booklet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_report_action (intervention_report_id INT NOT NULL, action_id INT NOT NULL, INDEX IDX_703BD5C1430C5E9 (intervention_report_id), INDEX IDX_703BD5C19D32F035 (action_id), PRIMARY KEY(intervention_report_id, action_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_report_technician (intervention_report_id INT NOT NULL, technician_id INT NOT NULL, INDEX IDX_ABD18E4E430C5E9 (intervention_report_id), INDEX IDX_ABD18E4EE6C5D496 (technician_id), PRIMARY KEY(intervention_report_id, technician_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_operating_system (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_software (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_software_intervention_report (id INT AUTO_INCREMENT NOT NULL, software_id INT NOT NULL, intervention_report_id INT NOT NULL, action VARCHAR(255) NOT NULL, INDEX IDX_5F21B563D7452741 (software_id), INDEX IDX_5F21B563430C5E9 (intervention_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_task (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, color VARCHAR(6) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_techncian (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_38B383A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_billing_line ADD CONSTRAINT FK_5035F0A78EAE3863 FOREIGN KEY (intervention_id) REFERENCES tbl_intervention (id)');
        $this->addSql('ALTER TABLE tbl_intervention ADD CONSTRAINT FK_2F4B6E3DA391D4AD FOREIGN KEY (operating_system_id) REFERENCES tbl_operating_system (id)');
        $this->addSql('ALTER TABLE tbl_intervention ADD CONSTRAINT FK_2F4B6E3D517FE9FE FOREIGN KEY (equipment_id) REFERENCES tbl_equipment (id)');
        $this->addSql('ALTER TABLE tbl_intervention ADD CONSTRAINT FK_2F4B6E3D19EB6921 FOREIGN KEY (client_id) REFERENCES tbl_client (id)');
        $this->addSql('ALTER TABLE tbl_intervention ADD CONSTRAINT FK_2F4B6E3D430C5E9 FOREIGN KEY (intervention_report_id) REFERENCES tbl_intervention_report (id)');
        $this->addSql('ALTER TABLE intervention_task ADD CONSTRAINT FK_5DC1C3E78EAE3863 FOREIGN KEY (intervention_id) REFERENCES tbl_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_task ADD CONSTRAINT FK_5DC1C3E78DB60186 FOREIGN KEY (task_id) REFERENCES tbl_task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_booklet ADD CONSTRAINT FK_73D84037430C5E9 FOREIGN KEY (intervention_report_id) REFERENCES tbl_intervention_report (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_booklet ADD CONSTRAINT FK_73D84037668144B3 FOREIGN KEY (booklet_id) REFERENCES tbl_booklet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_action ADD CONSTRAINT FK_703BD5C1430C5E9 FOREIGN KEY (intervention_report_id) REFERENCES tbl_intervention_report (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_action ADD CONSTRAINT FK_703BD5C19D32F035 FOREIGN KEY (action_id) REFERENCES tbl_action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_technician ADD CONSTRAINT FK_ABD18E4E430C5E9 FOREIGN KEY (intervention_report_id) REFERENCES tbl_intervention_report (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_report_technician ADD CONSTRAINT FK_ABD18E4EE6C5D496 FOREIGN KEY (technician_id) REFERENCES tbl_techncian (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tbl_software_intervention_report ADD CONSTRAINT FK_5F21B563D7452741 FOREIGN KEY (software_id) REFERENCES tbl_software (id)');
        $this->addSql('ALTER TABLE tbl_software_intervention_report ADD CONSTRAINT FK_5F21B563430C5E9 FOREIGN KEY (intervention_report_id) REFERENCES tbl_intervention_report (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_billing_line DROP FOREIGN KEY FK_5035F0A78EAE3863');
        $this->addSql('ALTER TABLE tbl_intervention DROP FOREIGN KEY FK_2F4B6E3DA391D4AD');
        $this->addSql('ALTER TABLE tbl_intervention DROP FOREIGN KEY FK_2F4B6E3D517FE9FE');
        $this->addSql('ALTER TABLE tbl_intervention DROP FOREIGN KEY FK_2F4B6E3D19EB6921');
        $this->addSql('ALTER TABLE tbl_intervention DROP FOREIGN KEY FK_2F4B6E3D430C5E9');
        $this->addSql('ALTER TABLE intervention_task DROP FOREIGN KEY FK_5DC1C3E78EAE3863');
        $this->addSql('ALTER TABLE intervention_task DROP FOREIGN KEY FK_5DC1C3E78DB60186');
        $this->addSql('ALTER TABLE intervention_report_booklet DROP FOREIGN KEY FK_73D84037430C5E9');
        $this->addSql('ALTER TABLE intervention_report_booklet DROP FOREIGN KEY FK_73D84037668144B3');
        $this->addSql('ALTER TABLE intervention_report_action DROP FOREIGN KEY FK_703BD5C1430C5E9');
        $this->addSql('ALTER TABLE intervention_report_action DROP FOREIGN KEY FK_703BD5C19D32F035');
        $this->addSql('ALTER TABLE intervention_report_technician DROP FOREIGN KEY FK_ABD18E4E430C5E9');
        $this->addSql('ALTER TABLE intervention_report_technician DROP FOREIGN KEY FK_ABD18E4EE6C5D496');
        $this->addSql('ALTER TABLE tbl_software_intervention_report DROP FOREIGN KEY FK_5F21B563D7452741');
        $this->addSql('ALTER TABLE tbl_software_intervention_report DROP FOREIGN KEY FK_5F21B563430C5E9');
        $this->addSql('DROP TABLE tbl_action');
        $this->addSql('DROP TABLE tbl_billing_line');
        $this->addSql('DROP TABLE tbl_booklet');
        $this->addSql('DROP TABLE tbl_client');
        $this->addSql('DROP TABLE tbl_equipment');
        $this->addSql('DROP TABLE tbl_intervention');
        $this->addSql('DROP TABLE intervention_task');
        $this->addSql('DROP TABLE tbl_intervention_report');
        $this->addSql('DROP TABLE intervention_report_booklet');
        $this->addSql('DROP TABLE intervention_report_action');
        $this->addSql('DROP TABLE intervention_report_technician');
        $this->addSql('DROP TABLE tbl_operating_system');
        $this->addSql('DROP TABLE tbl_software');
        $this->addSql('DROP TABLE tbl_software_intervention_report');
        $this->addSql('DROP TABLE tbl_task');
        $this->addSql('DROP TABLE tbl_techncian');
        $this->addSql('DROP TABLE tbl_user');
    }
}
