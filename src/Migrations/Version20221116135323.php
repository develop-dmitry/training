<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116135323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы operations';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('operations');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);

        $table->addColumn('amount', 'float');

        $table->addColumn('description', 'string');

        $table->addColumn('date', 'datetime');

        $table->addColumn('created_at', 'datetime');

        $table->addColumn('updated_at', 'datetime');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('operations');
    }
}
