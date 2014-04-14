<?php
namespace Werkzeugh\Corelib\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class SqlDumpCommand extends Command
{

    protected $name = 'sqldump';

    protected $description = 'shows commands to dump and import database';

    public function __construct()
    {
                parent::__construct();

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        $config = Config::get('database.connections');
        $connection = Config::get('database.default');
        $config = $config[$connection];

        $Command="mysqldump  -u {$config['username']} -p'{$config['password']}'  --skip-lock-tables {$config['database']} > /tmp/{$config['database']}.sql";
        $this->output->writeLn($Command);

        $hostname=trim(shell_exec("hostname"));

        $Command="scp  root@{$hostname}:/tmp/{$config['database']}.sql /tmp/{$config['database']}.sql";
        $this->output->writeLn($Command);

        $Command="mysql -u {$config['username']} -p'{$config['password']}' {$config['database']} < /tmp/{$config['database']}.sql";
        $this->output->writeLn($Command);

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    // protected function getArguments()
    // {
    //     return array(
    //         array(
    //             // 'package',
    //             // InputArgument::OPTIONAL,
    //             // '(Vendor\Package) The package to load the translations from, default is all!'
    //         ),
    //     );
    // }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            //array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}

