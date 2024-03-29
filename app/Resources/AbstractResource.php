<?php

namespace ModuleCulture\Resources;

use Framework\Baseapp\Resources\AbstractResource as AbstractResourceBase;

class AbstractResource extends AbstractResourceBase
{
    protected function getAppcode()
    {
        return 'culture';
    }

    protected function textMore($key, $text, $length = 80)
    {
        $len = strlen($text);
        if ($len <= $length) {
            return $text;
        }

        $extString = $this->resource->getResource()->strOperation($text, 'substr', ['start' => $length, 'length' => 2000]);
        $suffix = "<span><a id='{$key}' onclick='$(\"#{$key}\").hide();$(\"#{$key}Ext\").show();'>...更多</a></span><span id='{$key}Ext' style='display:none;'>{$extString}<a id='{$key}' onclick='$(\"#{$key}\").show();$(\"#{$key}Ext\").hide();'>...收起</a></span>";
        $text = $this->resource->getResource()->strOperation($text, 'substr', ['start' => 0, 'length' => $length]) . $suffix;
        return $text;

        $string = $this->resource->getResource()->strOperation($text, 'substr', ['start' => 0, 'length' => $length]);
        return "<span ><a title='{$text}'>{$string}...更多</a></span>";

    }

    protected function wrapPicture($url, $return = 'string', $width = '250', $height = '150')
    {
        if (empty($url)) {
            return '';
        }
        if ($return == 'original') {
            return $url;
        }
        $suffix = "?x-oss-process=image/resize,m_pad,h_{$height},w_{$width}";
        $url = $url . $suffix;
        return $return == 'html' ? "<img src='{$url}' />" : $url;
    }
}
