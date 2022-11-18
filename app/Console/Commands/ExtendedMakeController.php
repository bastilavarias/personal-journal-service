<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;


/**

 * @since 2020/11/29
 *
 * Usage
 *
 * This generator extends the php artisan make:controller --model={model} --api command
 * It will generate the necessary skeleton to create a CRUD and should contain all the basics for the task
 * It also generates
 *
 * php artisan magic:controller UserController --model=User --sub-folder=Some\Folder
 * name (UserController) - The name of the controller that you want to generate
 *      You can also pass a directory like V2\UserController for your convenience
 *
 * --model (User) - The Eloquent Model to be injected in the controller
 * --sub-folder (\) - A custom path that you want to use for both Requests and Events file
 *      You must add a backslash on both ends to make this work (e.g. \V2\ or \Admin\)
 */
class ExtendedMakeController extends ControllerMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic:controller
    {name : Controller name to be generated. Format: FooController}
    {--sub-folder= : Custom root folder for auto-generated requests}
    {--parent}
    {--model=}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function getStub()
    {
        $stub = '/stubs/controller.custom.stub';

        $this->genereateAPIRequests();
        $this->generateEvents();

        return $this->resolveStubPath($stub);
    }

    /**
     * Assume User model for example
     *
     * The requests will be generated on App\Http\Requests\User\{Method}User (e.g. GetUser)
     * By default, the requests will be TRUE (instead of Laravel's default of FALSE)
     * This allows you to work on the Controller by default
     * See /stubs/request.stub for more information
     *
     * The sub-folder parameter will be inserted before the Model folder
     * to allow to create versioned or custom requests
     */
    protected function genereateAPIRequests()
    {
        $model = str_replace('Controller', '', $this->argument('name'));
        $folder = $this->option('sub-folder');

        $names = [
            $folder . $model . '/Index' . $model,
            $folder . $model . '/Show' . $model,
            $folder . $model . '/Create' . $model,
            $folder . $model . '/Update' . $model,
            $folder . $model . '/Delete' . $model,
        ];

        foreach ($names as $name) {
            $this->call('make:request', [
                'name' => $name,
            ]);
        }
    }

    /**
     * This will auto-generate an event for each of the functions that you have
     * Allowing to easily extend each functions when necessary
     */
    public function generateEvents()
    {
        $model = str_replace('Controller', '', $this->argument('name'));
        $folder = $this->option('sub-folder');

        $names = [
            $folder . $model . '/' . $model . 'Collected',
            $folder . $model . '/' . $model . 'Fetched',
            $folder . $model . '/' . $model . 'Created',
            $folder . $model . '/' . $model . 'Updated',
            $folder . $model . '/' . $model . 'Deleted',
        ];

        foreach ($names as $name) {
            $this->call('make:event', [
                'name' => $name,
            ]);
        }
    }

    /**
     * DO NOT TOUCH IF YOU DON'T KNOW WHAT YOU'RE DOING
     * Build the model replacement values.
     *
     * @param  array  $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel(str_replace('Controller', '', $this->argument('name')));

        if (! class_exists($modelClass)) {
            $this->call('make:model', [
                'name'  => $modelClass,
                '-m'    => true,
            ]);
        }

        return array_merge($replace, [
            '{{ requestFolder }}' => $this->option('sub-folder'),
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }
}
