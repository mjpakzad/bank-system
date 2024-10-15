<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-repository {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository files for a model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');

        $interfaceStub = $this->getStub('repository.contract');
        $classStub = $this->getStub('repository.model');

        // Modify the stubs as needed and use them
        $interfaceContent = str_replace('{{model}}', $model, $interfaceStub);
        $classContent = str_replace('{{model}}', $model, $classStub);

        $this->createRepositoryInterface($model, $interfaceContent);
        $this->createRepositoryClass($model, $classContent);

        $this->info('Repository files generated successfully!');
    }

    private function getStub($name)
    {
        return File::get(base_path("app/Console/stubs/{$name}.stub"));
    }

    private function createRepositoryInterface($model, $content)
    {
        File::put(app_path("Repositories/Contracts/{$model}RepositoryInterface.php"), $content);
    }

    private function createRepositoryClass($model, $content)
    {
        File::put(app_path("Repositories/{$model}Repository.php"), $content);
    }
}
