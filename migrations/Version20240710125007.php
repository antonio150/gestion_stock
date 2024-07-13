<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710125007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_produit DROP FOREIGN KEY FK_3003FC84DCD6110');
        $this->addSql('ALTER TABLE stock_produit DROP FOREIGN KEY FK_3003FC84F347EFB');
        $this->addSql('DROP TABLE stock_produit');
        $this->addSql('ALTER TABLE produit ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27DCD6110 ON produit (stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock_produit (stock_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_3003FC84DCD6110 (stock_id), INDEX IDX_3003FC84F347EFB (produit_id), PRIMARY KEY(stock_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27DCD6110');
        $this->addSql('DROP INDEX IDX_29A5EC27DCD6110 ON produit');
        $this->addSql('ALTER TABLE produit DROP stock_id');
    }
}
