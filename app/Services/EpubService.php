<?php

declare(strict_types = 1);

namespace ModuleCulture\Services;

use PHPePub\Core\EPub;
use PHPePub\Core\EPubChapterSplitter;
use PHPePub\Core\Logger;
use PHPePub\Core\Structure\OPF\DublinCore;
use PHPePub\Core\Structure\OPF\MetaValue;
use PHPePub\Helpers\CalibreHelper;
use PHPePub\Helpers\URLHelper;
use PHPZip\Zip\File\Zip;

class EpubService extends AbstractService
{
    // Example.  // Create a test book for download.  // ePub uses XHTML 1.1, preferably strict.
    protected $contentStart = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"
        . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n"
        . "    \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n"
        . "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n"
        . "<head>"
        . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n"
        . "<title>{{BOOK_TITLE}}</title>\n"
        . "</head>\n"
        . "<body>\n";
    
    protected $bookEnd = "</body>\n</html>\n";
    protected $log;
    protected $book;
    protected $fileDir = './PHPePub';

    protected function pointRepository()
    {
        return false;
    }

    public function initBook()
    {
        $this->log = new Logger('Example', true);
        $this->book = new EPub(); // Default is EPub::BOOK_VERSION_EPUB2
        $this->book->setBookRoot('');
    
        $this->log->logLine("new EPub()");
        $this->log->logLine("EPub class version.: " . EPub::VERSION);
        $this->log->logLine("Zip version........: " . Zip::VERSION);
        $this->log->logLine("getCurrentServerURL: " . URLHelper::getCurrentServerURL());
        $this->log->logLine("getCurrentPageURL..: " . URLHelper::getCurrentPageURL());
    }

    public function renderBook($data)
    {
       // Title and Identifier are mandatory!
       $this->book->setTitle($data['name']);
       $this->book->setIdentifier("http://JohnJaneDoePublications.com/books/TestBook.html", EPub::IDENTIFIER_URI); // Could also be the ISBN number, preferred for published books, or a UUID.
       $this->book->setDescription($data['description']);
       $authorName = $data->authorInfo ? $data->authorInfo->name : '未名';
       $this->book->setAuthor($authorName, $data['name'] . '-author');
       $this->book->setSubject($data['name']);
    }

    public function renderMeta($data)
    {
       $this->log->logLine("Add Cover Image");
       $this->book->setCoverImage($data->coverUrl);
    }

    public function renderChapters($chapters)
    {
        foreach ($chapters as $chapter) {
            $content = '<p>' . str_replace("\n", '</p><p>', $chapter->getContent()) . '</p>';
            $content = $this->contentStart . "<h1>{$chapter['name']}</h1>\n" . $content . $this->bookEnd;
            //echo $content;exit();
            echo "{$chapter['serial']}: {$chapter['name']}\n";
            $this->book->addChapter("{$chapter['serial']}: {$chapter['name']}", "{$chapter['serial']}.html", $content, true, EPub::EXTERNAL_REF_ADD);
        }
    }
       
    public function outputBook($book)
    {
       $this->book->finalize(); // Finalize the book, and build the archive.
       //$path = $this->config->get('culture.epub_path');
       $path = $this->config->get('culture.epub_path') . $book['author'];
       if (!is_dir($path)) {
           mkdir($path);
       }
       //$this->book->saveBook($path . '/test', '');
       $this->book->saveBook($path . '/' . $book['code'], '');
       return true;
    }
}
