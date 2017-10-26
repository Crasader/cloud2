<?php
namespace Yeelight\Repositories\Generators\Commands;

use Illuminate\Console\Command;
use Yeelight\Repositories\Generators\FileAlreadyExistsException;
use Yeelight\Repositories\Generators\PresenterGenerator;
use Yeelight\Repositories\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PresenterCommand extends CommandBase
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'starter:presenter';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new presenter.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Presenter';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {

        try {
            (new PresenterGenerator([
                'name'  => $this->argument('name'),
                'force' => $this->option('force'),
            ]))->run();
            $this->info("Presenter created successfully.");

            if (!\File::exists(app_path() . '/Transformers/' . $this->argument('name') . 'Transformer.php')) {
                if ($this->confirm('Would you like to create a Transformer? [y|N]')) {
                    (new TransformerGenerator([
                        'name'  => $this->argument('name'),
                        'force' => $this->option('force'),
                    ]))->run();
                    $this->info("Transformer created successfully.");
                }
            }
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of model for which the presenter is being generated.',
                null
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ]
        ];
    }
}