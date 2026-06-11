<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Services extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service
        {name : Nombre del servicio, por ejemplo Product o ProductService}
        {--f|force : Sobrescribe el archivo si ya existe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera una clase de servicio con metodos REST para la capa de servicios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inputName = (string) $this->argument('name');
        $serviceClass = Str::finish(Str::studly($inputName), 'Service');

        $servicesPath = app_path('Services');
        $serviceFile = $servicesPath.'/'.$serviceClass.'.php';

        if (File::exists($serviceFile) && ! $this->option('force')) {
            $this->error("El servicio {$serviceClass} ya existe. Usa --force para sobrescribir.");

            return self::FAILURE;
        }

        File::ensureDirectoryExists($servicesPath);
        File::put($serviceFile, $this->buildServiceContent($serviceClass));

        $this->info("Servicio generado correctamente: app/Services/{$serviceClass}.php");

        return self::SUCCESS;
    }

    private function buildServiceContent(string $serviceClass): string
    {
        return <<<PHP
<?php

namespace App\Services;

class {$serviceClass}
{
    /**
     * Lista de recursos.
     */
    public function index(array \$filters = [], int \$perPage = 15)
    {
    }

    /**
     * Crea un nuevo recurso.
     */
    public function store(array \$data)
    {
    }

    /**
     * Muestra un recurso por ID.
     */
    public function show(string \$id)
    {
    }

    /**
     * Actualiza un recurso por ID.
     */
    public function update(string \$id, array \$data)
    {
    }

    /**
     * Elimina un recurso por ID.
     */
    public function destroy(string \$id)
    {
    }
}
PHP;
    }
}
