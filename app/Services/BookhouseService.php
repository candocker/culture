<?php

declare(strict_types = 1);

namespace ModuleCulture\Services;

use Illuminate\Support\Facades\Cache;

class BookhouseService extends AbstractService
{
    use BookhouseSeriesTrait;
    use BookhouseLoanTrait;

    public function getPointBooks($sortCode)
    {
        $books = $this->getModelObj('book')->where(['category' => $sortCode])->orderBy('orderlist', 'desc')->get();
        $books = $books->toArray();
        return $books;
    }
}
