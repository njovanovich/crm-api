<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310062540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, person INT DEFAULT NULL, business INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, invoice_lines LONGTEXT NOT NULL, INDEX IDX_6A2F2F95DE12AB56 (created_by), INDEX IDX_6A2F2F9516FE72E1 (updated_by), INDEX IDX_6A2F2F9534DCD176 (person), INDEX IDX_6A2F2F958D36E38 (business), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F95DE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9516FE72E1 FOREIGN KEY (updated_by) REFERENCES users (id)');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9534DCD176 FOREIGN KEY (person) REFERENCES people (id)');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F958D36E38 FOREIGN KEY (business) REFERENCES businesses (id)');
        $this->addSql('ALTER TABLE events CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE date_time date_time DATETIME DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE last_logged_in last_logged_in DATETIME DEFAULT NULL, CHANGE reset_password reset_password INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobs CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE lead lead INT DEFAULT NULL, CHANGE quote quote INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE job_id job_id VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE delivery_date delivery_date DATE DEFAULT NULL, CHANGE completed_date completed_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE businesses DROP FOREIGN KEY FK_2DCA55ECD4E6F81');
        $this->addSql('ALTER TABLE businesses CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE address address INT DEFAULT NULL, CHANGE abn abn VARCHAR(255) DEFAULT NULL, CHANGE acn acn VARCHAR(255) DEFAULT NULL, CHANGE misc_codes misc_codes VARCHAR(255) DEFAULT NULL, CHANGE number_of_employees number_of_employees INT DEFAULT NULL, CHANGE industry industry VARCHAR(255) DEFAULT NULL, CHANGE annual_revenue annual_revenue INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE website website VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE fax fax VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE businesses ADD CONSTRAINT FK_2DCA55ECD4E6F81 FOREIGN KEY (address) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quotes CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE lead lead INT DEFAULT NULL, CHANGE owner owner INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE quote_number quote_number VARCHAR(40) DEFAULT NULL, CHANGE total total INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notes CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE leads CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE owner owner INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE assigned_to assigned_to INT DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE lead_source lead_source VARCHAR(255) DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE campaign campaign VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE people ADD title VARCHAR(20) DEFAULT NULL, ADD job_title VARCHAR(255) DEFAULT NULL, CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE gender gender VARCHAR(10) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE address CHANGE address1 address1 VARCHAR(255) DEFAULT NULL, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL, CHANGE suburb suburb VARCHAR(255) DEFAULT NULL, CHANGE state state VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE invoices');
        $this->addSql('ALTER TABLE address CHANGE address1 address1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address2 address2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE suburb suburb VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE state state VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE postcode postcode VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE businesses DROP FOREIGN KEY FK_2DCA55ECD4E6F81');
        $this->addSql('ALTER TABLE businesses CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE address address INT DEFAULT NULL, CHANGE abn abn VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE acn acn VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE misc_codes misc_codes VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE number_of_employees number_of_employees INT DEFAULT NULL, CHANGE industry industry VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE annual_revenue annual_revenue INT DEFAULT NULL, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE website website VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fax fax VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE businesses ADD CONSTRAINT FK_2DCA55ECD4E6F81 FOREIGN KEY (address) REFERENCES address (id)');
        $this->addSql('ALTER TABLE events CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_time date_time DATETIME DEFAULT \'NULL\', CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE jobs CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE lead lead INT DEFAULT NULL, CHANGE quote quote INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE job_id job_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE delivery_date delivery_date DATE DEFAULT \'NULL\', CHANGE completed_date completed_date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE leads CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE owner owner INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE assigned_to assigned_to INT DEFAULT NULL, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE lead_source lead_source VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE amount amount INT DEFAULT NULL, CHANGE campaign campaign VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE notes CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE people DROP title, DROP job_title, CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE middle_name middle_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE quotes CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE person person INT DEFAULT NULL, CHANGE lead lead INT DEFAULT NULL, CHANGE owner owner INT DEFAULT NULL, CHANGE business business INT DEFAULT NULL, CHANGE quote_number quote_number VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE total total INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_by created_by INT DEFAULT NULL, CHANGE updated_by updated_by INT DEFAULT NULL, CHANGE reset_password reset_password INT DEFAULT NULL, CHANGE last_logged_in last_logged_in DATETIME DEFAULT \'NULL\'');
    }
}
