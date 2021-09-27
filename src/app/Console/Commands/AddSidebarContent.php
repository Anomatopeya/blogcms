<?php

namespace Aldwyn\Blogcms\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddSidebarContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:init-sidebar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize default sidebar menu';

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
        $path = 'resources/views/vendor/backpack/base/inc/sidebar_content.blade.php';
        $disk_name = config('backpack.base.root_disk_name');
        $disk = Storage::disk($disk_name);
        $code = $this->sidebarContent();

        if ($disk->exists($path)) {
            $contents = $disk->get($path);
            $file_lines = file($disk->path($path), FILE_IGNORE_NEW_LINES);

            if ($this->getLastLineNumberThatContains($code, $file_lines)) {
                return $this->comment('Sidebar item already existed.');
            }

            if ($disk->put($path, $contents.PHP_EOL.$code)) {
                $this->info('Successfully added code to sidebar_content file.');
            } else {
                $this->error('Could not write to sidebar_content file.');
            }
        } else {
            $this->error('The sidebar_content file does not exist. Make sure Backpack is properly installed.');
        }
    }

    /**
     * Parse the given file stream and return the line number where a string is found.
     *
     * @param  string  $needle  The string that's being searched for.
     * @param  array  $haystack  The file where the search is being performed.
     * @return bool|int The last line number where the string was found. Or false.
     */
    private function getLastLineNumberThatContains($needle, $haystack)
    {
        $matchingLines = array_filter($haystack, function ($k) use ($needle) {
            return strpos($k, $needle) !== false;
        });

        if ($matchingLines) {
            return array_key_last($matchingLines);
        }

        return false;
    }

    private function sidebarContent()
    {
//        "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('$nameKebab') }}'><i class='nav-icon la la-question'></i> $namePlural</a></li>
        return "<li class='nav-item nav-dropdown'>
            <a class='nav-link nav-dropdown-toggle' href='#'><i class='nav-icon la la-book-reader'></i> {{ _('Content') }} </a>
            <ul class='nav-dropdown-items'>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-hashtag'></i>
                    {{_('Tags')}}</a></li>
                <li class='nav-item nav-dropdown'>
                    <a class='nav-link nav-dropdown-toggle' href='#'><i class='nav-icon la la-blog'></i> {{ _('Blog') }} </a>
                    <ul class='nav-dropdown-items'>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('articlecategory') }}'><i class='nav-icon la  la-bold'></i> {{_('ArticleCategories')}}</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('article') }}'><i class='nav-icon la la-file-alt'></i>
                            {{_('Articles')}}</a></li>
                    </ul>
                </li>
            </ul>
        </li>";
    }
}
