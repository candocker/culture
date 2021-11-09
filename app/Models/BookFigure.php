<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BookFigure extends AbstractModel
{
    use SoftDeletes;
    protected $table = 'book_figure';
    protected $guarded = ['id'];

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }

    public function figure()
    {
        return $this->hasOne(Figure::class, 'code', 'figure_code');
    }

    public function recordCreative($string, $bookCode)
    {
        $this->where('book_code', $bookCode)->delete();
        $string = str_replace(['：'], [':'], $string);
        $titles = strpos($string, '||') !== false ? explode('||', $string) : [$string];
        foreach ($titles as $title) {
            if (strpos($title, ':') === false) {
                continue;
            }
            list($type, $figureCode) = explode(':', $title);
            $this->createRecord($type, $bookCode, $figureCode);
        }
        return true;
    }

    protected function createRecord($type, $bookCode, $figureCode)
    {
        $data = ['type' => $type, 'book_code' => $bookCode, 'figure_code' => $figureCode];
        $exist = $this->withTrashed()->where($data)->first();
        if ($exist) {
            return $exist->trashed() ? $exist->restore() : true;
        }

        return $this->create($data);
    }
}
