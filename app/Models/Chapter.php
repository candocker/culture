<?php

namespace ModuleCulture\Models;

class Chapter extends AbstractModel
{
    protected $table = 'chapter';
    protected $guarded = ['id'];

    public function tagInfos()
    {
        return $this->hasMany(TagInfo::class, 'info_id', 'id')->where('info_type', 'book');
    }

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }

    public function author()
    {
        return $this->hasOne(Figure::class, 'code', 'author');
    }

	public function getContent()
	{
		return $this->getChapterFile($this);
	}
}
