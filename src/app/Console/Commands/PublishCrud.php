<?php

namespace Aldwyn\Blogcms\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PublishCrud extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:publish-crud';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:publish-crud
                            {crud : short crud name (ex: article)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes a CMS admin CRUD so you can make changes to it, for your project.';

    /**
     * The directory where the views will be published FROM.
     *
     * @var string
     */
    public $sourcePath = 'vendor/aldwyn/blogcms/src/app/Http/Controllers/AdminPublishes/';

    /**
     * The directory where the views will pe published TO.
     *
     * @var string
     */
    public $destinationPath = 'app/Http/Controllers/Admin/';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = (string) $this->argument('crud');
        $nameTitle = ucfirst(Str::camel($name));
        $nameKebab = Str::kebab($nameTitle);
        $this->file = ucfirst(strtolower($nameKebab.'CrudController';

        return $this->publishFile($this->file, $nameKebab, $nameTitle);
    }

    /**
     * Take a blade file from the vendor folder and publish it to the resources folder.
     *
     * @param  string  $file  The filename without extension
     * @return void
     */
    protected function publishFile($file, $nameKebab, $nameTitle)
    {
        $sourceFile = $this->sourcePath.$file.'.php';
        $copiedFile = $this->destinationPath.$file.'.php';

        if (! file_exists($sourceFile)) {
            return $this->error(
                'Cannot find source CRUD file at '
                .$sourceFile.
                ' - make sure you\'ve picked an existing CRUD file'
            );
        } else {
            $canCopy = true;

            if (file_exists($copiedFile)) {
                $canCopy = $this->confirm(
                    'File already exists at '
                    .$copiedFile.
                    ' - do you want to overwrite it?'
                );
            }

            if ($canCopy) {
                $path = pathinfo($copiedFile);

                if (! file_exists($path['dirname'])) {
                    mkdir($path['dirname'], 0755, true);
                }

                if (copy($sourceFile, $copiedFile)) {
                    $this->info('Copied to '.$copiedFile);
                } else {
                    return $this->error(
                        'Failed to copy '
                        .$sourceFile.
                        ' to '
                        .$copiedFile.
                        ' for unknown reason'
                    );
                }
            }
        }
        // Create the CRUD route
        $this->call('cms:add-custom-route', [
            'code' => "Route::crud('$nameKebab', '{$nameTitle}CrudController');",
        ]);
    }
}
