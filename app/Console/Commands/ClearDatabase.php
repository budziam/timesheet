<?php
namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-db {--database=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes all tables';

    public function handle()
    {
        if (!is_null($database = $this->input->getOption('database'))) {
            DB::setDefaultConnection($database);
        }

        do {
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                $propertyName = 'Tables_in_' . DB::getDatabaseName();
                $tableName = $table->{$propertyName};

                try {
                    DB::statement('drop table ' . $tableName);
                } catch (\Exception $e) {
                    //
                }
            }
        } while (count($tables));
    }
}