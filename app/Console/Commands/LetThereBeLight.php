<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LetThereBeLight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'let:there:be:light {name : Controller name to be generated. Format: FooController} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('name');
        $controller = $model . 'Controller';

        $this->call('magic:controller', [
                'name' => $controller,
                '--model'   => $model,
            ]);
        return 0;
    }
}
