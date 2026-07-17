<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSearchHistoryTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('search_history');
        
        $table->addColumn('city_name', 'string', ['limit' => 100, 'null' => false])
              ->addColumn('temperature', 'decimal', ['precision' => 4, 'scale' => 1, 'null' => false])
              ->addColumn('feels_like', 'decimal', ['precision' => 4, 'scale' => 1, 'null' => false])
              ->addColumn('humidity', 'integer', ['null' => false])
              ->addColumn('description', 'string', ['limit' => 150, 'null' => false])
              ->addColumn('searched_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
