<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180513175718 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137514956FD');
        $this->addSql('DROP INDEX IDX_DA88B137514956FD ON recipe');
        $this->addSql('ALTER TABLE recipe CHANGE collection_id coll_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1376AA2FA5C FOREIGN KEY (coll_id) REFERENCES `collection` (id)');
        $this->addSql('CREATE INDEX IDX_DA88B1376AA2FA5C ON recipe (coll_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1376AA2FA5C');
        $this->addSql('DROP INDEX IDX_DA88B1376AA2FA5C ON recipe');
        $this->addSql('ALTER TABLE recipe CHANGE coll_id collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137514956FD FOREIGN KEY (collection_id) REFERENCES collection (id)');
        $this->addSql('CREATE INDEX IDX_DA88B137514956FD ON recipe (collection_id)');
    }
}
