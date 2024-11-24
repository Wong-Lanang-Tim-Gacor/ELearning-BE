<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface 
                            {name : The name of the interface (e.g., CategoryRepositoryInterface)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface file in the Contracts/Interfaces directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the name of the interface
        $name = $this->argument('name');

        // Define the directory and file path
        $baseDirectory = base_path('app/Contracts/Interfaces');
        $filePath = "{$baseDirectory}/{$name}Interface.php";

        // Check if the file already exists
        if (File::exists($filePath)) {
            $this->error("Interface already exists at {$filePath}");
            return Command::FAILURE;
        }

        // Ensure the directory exists
        if (!File::exists($baseDirectory)) {
            File::makeDirectory($baseDirectory, 0755, true);
        }

        // Define the namespace and class
        $namespaceDeclaration = "App\\Contracts\\Interfaces";

        // Create the interface file content
        $content = <<<PHP
<?php

namespace {$namespaceDeclaration};

interface {$name}
{
    // Define your methods here
}
PHP;

        // Write the file
        File::put($filePath, $content);

        $this->info("Interface created successfully at {$filePath}");
        return Command::SUCCESS;
    }
}
