<?php

namespace ModuleCulture\Commands;

class GeneratorEpubCommand extends AbstractCommand
{
    protected $signature = 'make:epub';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create epub for books';

    public function handle()
    {
        $type = $this->argument('type');
        $options = $this->option('options');
        file_put_contents('/tmp/text.txt', date('Y-m-d H:i:s') . '--'. $type. '==' . $options . 'ssssssssss', FILE_APPEND);
        echo 'sssssssssss';exit();
    }
}
