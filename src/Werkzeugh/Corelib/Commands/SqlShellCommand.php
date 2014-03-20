<?php
namespace Werkzeugh\Corelib\Commands;

use Illuminate\Console\Command;

class SqlShellCommand extends Command
{

    protected $name = 'sqlshell';

    protected $description = 'starts an interactive db-shell';

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


        $config = \Config::get('database.connections');
        $connection = \Config::get('database.default');
        $config = $config[$connection];

        $Command="mysql  -u {$config['username']} -p{$config['password']} {$config['database']}";
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

