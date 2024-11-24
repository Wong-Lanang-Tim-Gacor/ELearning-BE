<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new repository class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Contracts/Repository/{$name}Repository.php");

        if (File::exists($path)) {
            $this->error("Repository {$name} already exists!");
            return;
        }

        $stub = $this->getStub();
        $content = str_replace('{{name}}', $name, $stub);
        File::put($path, $content);

        $this->info("Repository {$name}Repository created successfully.");
    }

    private function getStub()
    {
        return <<<EOT
        <?php

        namespace App\Contracts\Repository;

        use App\Contracts\Repository\BaseRepository;
        use App\Models\{{name}};

        class {{name}}Repository extends BaseRepository
        {
            public function __construct({{name}} \$model)
            {
                parent::__construct(\$model);
            }
        }
        EOT;
    }
}
