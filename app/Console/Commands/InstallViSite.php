<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InstallViSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vi:install {package=blog}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the vi admin package option package=(blog|company|shop|full)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $package = 'Blog';
        // $this->choice('Please Choose Package? ', ['Blog', 'Company', 'Shop', 'Advanced'], 0);
        // $this->info('Display this on the '.$package);
        $this->initDatabase($package);
    }

    /**
     * Create tables and seed it.
     *
     * @param $package
     * @return void
     */
    public function initDatabase($package)
    {
        $tables = DB::select('SHOW TABLES');
        $colname = 'Tables_in_' . env('DB_DATABASE', 'vi-site');
        if (count($tables) > 0) {
            $datalist = [];
            foreach($tables as $table) {
                if (isset($table->$colname) && $table->$colname !== 'vi_locations') {
                    $datalist[] = $table->$colname;
                }
            }
            if (count($datalist) > 0) {
                $datalist = implode(',', $datalist);
                DB::beginTransaction();
                //turn off referential integrity
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                DB::statement("DROP TABLE $datalist");
                //turn referential integrity back on
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                DB::commit();
                $this->comment(PHP_EOL."If no errors showed up, all tables were dropped".PHP_EOL);
            }
        }
        $classSeeder = 'App\database\seeds\ViPackage' . $package . 'Seeder';
        if (class_exists($classSeeder)) {
            $this->call('admin:install');
            $this->call('db:seed', ['--class' => $classSeeder]);
        } else {
            $this->error('Not support package [' . $package . ']');
        }
    }
}
