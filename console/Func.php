<?php namespace Quadrowin\EaxOctober\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class Func extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'eax:func';

    /**
     * @var string The console command description.
     */
    protected $description = 'Exec any php function';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $class_name = $this->argument('class');
        $method_name = $this->argument('method');
        if (!class_exists($class_name)) {
            throw new \LogicException('Class not found: ' . $class_name);
        }
        $obj = new $class_name;
        if (!method_exists($obj, $method_name)) {
            throw new \LogicException('Method not exists: ' . $class_name . '::' . $method_name);
        }
        $arguments = $this->argument('arguments');
        $this->output->writeln('Start at ' . date('Y-m-d H:i:s'));
        $result = call_user_func_array([$obj, $method_name], $arguments);
        $this->output->writeln('Finished at ' . date('Y-m-d H:i:s'));

        $this->output->writeln(
            json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            SymfonyStyle::OUTPUT_RAW
        );
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['class', InputArgument::REQUIRED, 'Class name'],
            ['method', InputArgument::REQUIRED, 'Method name'],
            ['arguments', InputArgument::IS_ARRAY, 'Method arguments'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
