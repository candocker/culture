<?php

namespace ModuleCulture\Models;

//use Elasticquent\ElasticquentTrait;
//use Laravel\Scout\Searchable;
use ModulePassport\Models\TagInfo;

class Book extends AbstractModel
{
    //use ElasticquentTrait;
    //use Searchable;

    protected $table = 'book';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = ['id'];
    protected $mappingProperties = [
       'name' => [
            'type' => 'string',
            'analyzer' => 'standard'
        ]
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'book_code', 'code')->orderBy('serial', 'asc');
    }

    public function tagInfos()
    {
        return $this->hasMany(TagInfo::class, 'info_id', 'id')->where('info_table', 'book');
    }

    public function authorData()
    {
        $data = BookFigure::where(['book_code' => $this->code])->first();
        if (empty($data)) {
            return new BookFigure();
        }
        return $data->figure;
    }

    public function authorInfo()
    {
        return $this->hasOne(Figure::class, 'code', 'author');
    }

    public function authorInfos($type = null)
    {
        $datas = [];
        $where = ['book_code' => $this->code];
        if (!is_null($type)) {
            $where['type'] = $type;
        }
        return BookFigure::where($where)->get();
    }

    public function formatAuthorData($return = 'name')
    {
        $infos = $this->authorInfos();
        if ($return == 'name') {
            $string = '';
            foreach ($infos as $info) {
                $string .= $info->figure ? $info->figure['name'] . '-' . $info->figure['name_code'] : '匿名';
            }
            return $string;
        }
    }

    public function getCoverUrlAttribute()
    {
        $url = $this->getRepositoryObj()->getAttachmentUrl(['info_table' => 'book', 'info_field' => 'cover', 'info_id' => $this->code]);
        $url = $url ? $url : 'http://ossfile.canliang.wang/book/cover_scholarism/0921a8be-f9e6-4a31-87e3-b31f023b96a0.jpg';
        return $url;
    }

    public function afterSave()
    {
        $request = request();
        $creative = $request->input('creative');
        if (!is_null($creative)) {
            $this->getModelObj('bookFigure')->recordCreative($creative, $this->code);
        }

        return true;
    }

    public function getCreative($type = 'all')
    {
        $infos = $this->getCreativeDatas();
        $repository = $this->getRepositoryObj('book');
        $creativeDatas = $repository->getKeyValues('creative');
        $result = [];
        foreach ($infos as $key => $value) {
            $kName = $creativeDatas[$key] ?? $key;
            foreach ($value as $fCode => $fName) {
                $result["{$key}:{$fCode}"] = "{$kName}:{$fName}";
            }
        }
        return ['source' => $result, 'show' => implode('||', $result)];
    }

    public function getCreativeDatas($type = null)
    {
        $where = ['book_code' => $this->code];
        $infos = $this->getModelObj('bookFigure')->where($where)->orderBy('type')->get();
        $results = [];
        foreach ($infos as $info) {
            $figure = $info->figure;
            $results[$info['type']][$figure['code']] = $figure['name'];
        }
        if (!is_null($type)) {
            return $results[$type] ?? [];
        }
        return $results;
    }

    /**
     * 获取模型的可搜索数据
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $data = [
            'id' => $this->id,
            //'name' => $this->name,
            //'note' => $this->note,
            //'description' => $this->description,
        ];

        return $data;
    }

    /**
     * 得到该模型索引的名称。
     *
     * @return string
     */
    public function searchableAs()
    {
        //return 'book';
        return '_doc';//laravel74_culture';
    }

    /**
     * 获取模型主键
     *
     * @return mixed
     */
    /*public function getScoutKey()
    {
        return $this->code;
    }*/

     /**
     * 获取模型键名
     *
     * @return mixed
     */
    /*public function getScoutKeyName()
    {
        return 'code';
    }*/
}
