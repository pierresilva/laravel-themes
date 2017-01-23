<?php

namespace pierresilva\Themes\Console\Generators;

use pierresilva\Themes\Themes;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;

class GenerateThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:theme
        {slug : The slug of the theme. Example: "bootstrap"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create a skeleton for a new Laravel Theme!';

    /**
     * The themes instance.
     *
     * @var Themes
     */
    protected $theme;

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Themes $theme
     */
    public function __construct(Filesystem $files, Themes $theme)
    {
        parent::__construct();

        $this->files = $files;
        $this->theme = $theme;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->container['slug'] = str_slug($this->argument('slug'));
        $this->container['name'] = studly_case($this->container['slug']);
        $this->container['version'] = '1.0';
        $this->container['author'] = '';
        $this->container['description'] = 'This is the description for the ' . $this->container['name'] . ' theme.';

        $this->displayHeader('generate_theme_introduction');

        $this->stepOne();
    }

    /**
     * Step 1: Configure theme manifest.
     *
     * @return mixed
     */
    private function stepOne()
    {
        $this->displayHeader('generate_theme_step_1');

        $this->container['name'] = $this->ask('Please enter the name of the theme:', $this->container['name']);
        $this->container['slug'] = $this->ask('Please enter the slug for the theme:', $this->container['slug']);
        $this->container['version'] = $this->ask('Please enter the theme version:', $this->container['version']);
        $this->container['author'] = $this->ask('Please enter the author name of the theme:', $this->container['author']);
        $this->container['description'] = $this->ask('Please enter the description of the theme:', $this->container['description']);

        $this->comment('You have provided the following manifest information:');
        $this->comment('Name:                       ' . $this->container['name']);
        $this->comment('Slug:                       ' . $this->container['slug']);
        $this->comment('Version:                    ' . $this->container['version']);
        $this->comment('Author:                     ' . $this->container['author']);
        $this->comment('Description:                ' . $this->container['description']);

        if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
            $this->comment('Thanks! That\'s all we need.');
            $this->comment('Now relax while your theme is generated.');

            $this->generate();
        } else {
            return $this->stepOne();
        }

        return true;
    }

    /**
     * Generate the theme.
     */
    protected function generate()
    {
        $steps = [
            'Generating theme...' => 'generateTheme',
        ];

        $progress = new ProgressBar($this->output, count($steps));
        $progress->start();

        foreach ($steps as $message => $function) {
            $progress->setMessage($message);

            $this->$function();

            $progress->advance();
        }

        $progress->finish();

        event($this->container['slug'] . '.theme.generated');

        $this->info("\nTheme generated successfully.");
        $this->comment("You can see it in \"./public/" . config('themes.paths.base') . "/" . $this->container['slug'] . "/\"");
        $this->info("\nUse it with the falowing code:");
        $this->comment("\nTheme::setActive('" . $this->container['slug'] . "');\nTheme::view('welcome', \$data);");
    }

    /**
     * Generate defined theme folders.
     */
    protected function generateTheme()
    {
        // Create base themes directory
        if (!$this->files->isDirectory(public_path(config('themes.paths.base')))) {
            $this->files->makeDirectory(public_path(config('themes.paths.base')));
        }

        $directory = config('themes.paths.absolute') . '/' . $this->container['slug'];
        $source = __DIR__ . '/../../../resources/theme';

        $this->files->makeDirectory($directory);

        $sourceFiles = $this->files->allFiles($source, true);

        foreach ($sourceFiles as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $subPath = $file->getRelativePathname();

            $filePath = $directory . '/' . $subPath;
            $dir = dirname($filePath);

            if (!$this->files->isDirectory($dir)) {
                $this->files->makeDirectory($dir, 0755, true);
            }

            $this->files->put($filePath, $contents);
        }
    }

    /**
     * Pull the given stub file contents and display them on screen.
     *
     * @param string $file
     * @param string $level
     *
     * @return mixed
     */
    protected function displayHeader($file = '', $level = 'info')
    {
        $stub = $this->files->get(__DIR__ . '/../../../resources/stubs/console/' . $file . '.stub');

        return $this->$level($stub);
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyName',
            'DummySlug',
            'DummyVersion',
            'DummyDescription',
            'DummyAuthor'
        ];

        $replace = [
            $this->container['name'],
            $this->container['slug'],
            $this->container['version'],
            $this->container['description'],
            $this->container['author'],
        ];

        return str_replace($find, $replace, $contents);
    }
}
