<?php
declare(strict_types = 1);

namespace ModuleCulture\Services;

use Swoolecan\Foundation\Helpers\DatetimeTool;

class CultureArticleService extends AbstractService
{
    public function getListInfos($modelCode, $where, $withPage = false)
    {
        $query = $this->getModelObj($modelCode);
        if ($where) {
            $query->where($where);
        }
        $infos = $query->get();
        $datas = $this->formatForBlog($infos);
        if (empty($withPage)) {
            return $datas;
        }
        return [
            'data' => $datas,
            'pagination' => $this->getPageData(),
        ];
    }

    public function getInfoRelate($modelCode, $id)
    {
        $model = $this->getModelObj($modelCode);
        $info = $model->where([['id', '>', 200]])->first();
        $preInfo = $model->preInfo(['where' => [['id', '<', $id]]]);
        $nextInfo = $model->preInfo(['where' => [['id', '>', $id]]]);
        $relateInfos = $model->relateDatas(8, []);

        return [
            'prev_article' => $preInfo ? $preInfo->formatForBlog() : null,
            'next_article' => $nextInfo ? $nextInfo->formatForBlog() : null,
            'related_articles' => $this->formatForBlog($relateInfos),
        ];
    }

    public function getInfoDetail($modelCode, $where, $throw = true)
    {
        $model = $this->getModelObj($modelCode);
        $info = $model->where($where)->first();
        if (empty($info)) {
            \Log::info('iii');
            return $throw ? $this->resource->throwException(404, '信息不存在') : false;
        }
        return $info->formatForBlog('detail');
    }

    public function getArticleCalendar()
    {
        $datetimeTool = new DatetimeTool();
        $now = $datetimeTool->getNow();
        for ($i = 1; $i < 30; $i++) {
            $date = $now->subDays(rand(2, 5))->format('Y-m-d');
            $datas[] = ['date' => $date, 'count' => rand(3, 10)];
        }
        return $datas;
    }

    public function getOptionData()
    {
        return [
            '_id' => '589e01b75af07d59124234cd',
            'title' => 'Surmon.me',
            'sub_title' => '来苏之望',
            'description' => '凡心所向，素履所往；生如逆旅，一苇以航。',
            'site_url' => 'https://surmon.me',
            'site_email' => 'i@surmon.me',
            'keywords' => ['Surmon', '苏尔蒙', 'surmon 前端技术博客', 'surmon.me blog'],
            '__v' => 128,
            'meta' => ['likes' => 636],
            'update_at' => '2022-03-05T13:40:10.388Z',
            'ad_config' => json_encode($this->getAdDatas()),
            'friend_links' => [
                ['name' => '吕立青的博客', 'value' => 'https://blog.jimmylv.info'],
                ['name' => 'nighca\'s log', 'value' => 'https://nighca.me'],
                ['name' => 'vzchn\'s Blog', 'value' => 'https://blog.vzchn.com'],
            ],
          'statement' => '',
        ];
    }


    protected function getAdDatas()
    {
        return [
            'BACK_UP_LINKS' => [
              '阿里云 云大使（官方活动页）' => 'https://www.aliyun.com/activity?source=5176.11533457&userCode=pu7fghvl#promotionArea',
              '阿里云 云小站（领取优惠券固定）' => 'https://www.aliyun.com/minisite/goods?userCode=pu7fghvl',
            ],
            'PC_CARROUSEL' => false,
            'PC_NAV' => [
                [
                    'icon' => 'icon-aliyun',
                    'color' => '#ff6a00',
                    'url' => 'https://www.aliyun.com/minisite/goods?userCode=pu7fghvl',
                    'i18n' => ['en' => 'Aliyun', 'zh' => '云上爆款'],
                ],
            ],
            'PC_ASIDE_SWIPER' => [
                [
                    'url' => 'https://cloud.tencent.com/act/cps/redirect?redirect=1077&cps_key=8a58019c32584cfa76de23f9986c17ed&from=console',
                    'src' => 'https://static.surmon.me/assets/pc-aside-tencent.jpg',
                ],
                [
                    'url' => 'https://www.aliyun.com/minisite/goods?userCode=pu7fghvl',
                    'src' => 'https://static.surmon.me/assets/pc-aside-1-aliyun.jpg',
                ],
            ],
            'PC_MERCH_PRODUCTS' => [
                [ 
                    'name' => 'DJI 大疆 御 Mavic air2 无人机',
                    'description' => '性价比高，皮实好用',
                    'detail' => '购置一年，累计飞行超过 200km，去过新疆和青藏高原，拍过不少大片，DJI 现在出新款了，但是定位都较贵，Air2 性价比依旧很高，推荐畅飞套装',
                    'src' => 'https://static.surmon.me/merch/products/dji-mavic-air-2.jpg',
                    'url' => 'https://union-click.jd.com/jdc?e=&p=JF8BAM4JK1olXDYCVV9cCEgRC28JHVolGVlaCgFtUQ5SQi0DBUVNGFJeSwUIFxlJX3EIGloUXQUEXF5cDkoIWipURmt-JXNaHD49Yy5_SwthRj58Q3pSDB09BEcnAl8IGloVXwcFVlxVOHsXBF9edVsUXAcDVV1fDEonAl8IHFkcXQMLUVlZAU4SM2gIEmtOCGgGUg5cDB4WCm0LSQgXbTYyV25tOEsnAF9KdV1CVQBQUg0JD08QA2oKHwkdVQ5RV1wJXU0WU2kAGAxBbQQDVVpUOA',
                ],
                [
                    'name' => 'GoPro HERO10 Black',
                    'description' => '地表最强运动相机',
                    'detail' => '我和我的的狗7一起去过芽庄潜水，和摩托车一起穿越阿尔金山，从未掉过链子，当然既然已经有 10 了，那就不要买 7/8/9 了，无论是小屏还是 5k 都是很值得买的点',
                    'src' => 'https://static.surmon.me/merch/products/gopro-9.jpg',
                    'url' => 'https://union-click.jd.com/jdc?e=&p=JF8BANYJK1olXgEAXV5aCEgTB18IGloUXQQFU1taC08nRzBQRQQlBENHFRxWFlVPRjtUBABAQlRcCEBdCUoWA20PHF4SXgIdDRsBVXtudBV0fxhjNGRwKlkHcwpBAy9OY15TUQoyVW5dCUoXAW4PGVkdbTYCU24fZkgWAG9eRRpWAzYDZF5aCkIXBmYPGV4SXw4yU15UOBBCbWsOS1oRCAcLVl0PW0knM18LK2slXTYBZBwzXEwSVGZYHwwUXFRQUQ5dCkJAC28KS1IUDwRVVgteCU4nAW4JH1Il',
                ],
            ],
            'PC_MERCH_BROKERS' => [
                [
                    'name' => '富途牛牛',
                    'description' => '腾讯旗下，业界第一',
                    'detail' => '虽然我去年在美股亏了小十万，但还是得说富途是所有港美股券商中做的最好的；体验优异、港美股融资打新均支持；自有港股暗盘；支持 eDDA 入金，用户庞大；富途是我的主交易账户',
                    'src' => 'https://static.surmon.me/merch/brokers/futu.webp',
                    'url' => 'https://growth.futuhainan.com/new-customer-2101?code=4a751a5c06d6be724b7a18dd6d271aa2',
                ],
                [
                    'name' => '老虎证券',
                    'description' => '港美股交易均支持',
                    'detail' => '老虎从去年收购了香港一些本土券商之后有了新的牌照，也跻身全地域券商的行列了；App 体验优秀，出入金快，港股 IPO 手续费固定￥100，由于有美国牌照，老虎是少有的支持美股打新的券商，我主要用来打新',
                    'src' => 'https://static.surmon.me/merch/brokers/tiger.webp',
                    'url' => 'https://www-web.itiger.com/activity/forapp/invitation/*LNLOGI-signup.html?invite=LNLOGI#/',
                ],
            ],
        ];
    }

    public function getPageData()
    {
        return [
            'total' => 156,
            'current_page' => 1,
            'per_page' => 16,
            'total_page' => 10,
        ];
    }

    protected function formatForBlog($infos)
    {
        $datas = [];
        foreach ($infos as $info) {
            $datas[] = $info->formatForBlog();
        }
        return $datas;
    }
}
