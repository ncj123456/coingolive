<?php

namespace Controller;

class CronVideo {

    function save() {

        $channels = new \Model\VideoChannel();
        $rs = $channels->findAll();


        $db = \Base\DB::connect();
        $db->beginTransaction();

        (new \Model\Video($db))->deleteAll();


        foreach ($rs as $r) {

            $id_channel = $r['id'];
            $url = "https://www.youtube.com/feeds/videos.xml?channel_id=" . $id_channel;
            $sitemap = file_get_contents($url);

            $data = simplexml_load_string($sitemap);

//            echo ($data->title);
//            die;
            $ch = new \Model\VideoChannel();
            $ch->setTitle($data->title);
            $ch->setPublished($data->published);
            $ch->update('id=:id', ['id' => $id_channel]);

            $itens = $data->entry;


            foreach ($itens as $video_xml) {

                $video = new \Model\Video($db);
                $video->id_video = (string) str_replace('yt:video:', '', $video_xml->id);
                $video->id_channel = $id_channel;
                $video->link = (string) $video_xml->link->attributes()->href;
                $video->title = (string) $video_xml->title;
                $video->published = $video_xml->published;
//                $video->updated = $video_xml->updated;
                $video->description = (string) $video_xml->children('http://search.yahoo.com/mrss/')->group->description;
                $video->thumbnail = (string) $video_xml->children('http://search.yahoo.com/mrss/')->group->thumbnail->attributes()->url;
//                $video->thumbnail_width = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->thumbnail->attributes()->width;
//                $video->thumbnail_height = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->thumbnail->attributes()->height;
                $video->rating = (float) $video_xml->children('http://search.yahoo.com/mrss/')->group->community->starRating->attributes()->average;
                $video->likes = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->community->starRating->attributes()->count;
//                $video->rating_min = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->community->starRating->attributes()->min;
//                $video->rating_max = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->community->starRating->attributes()->max;
                $video->views = (int) $video_xml->children('http://search.yahoo.com/mrss/')->group->community->statistics->attributes()->views;

//                print_r(get_object_vars($video));die;

                if (!$this->checkValid($video->title)) {
                    continue;
                }
                echo $video->title . PHP_EOL;
                $video->insert();
//                print_r($video);
//                $this->channel->videos[] = $video;
            }
        }

        $db->commit();
    }

    function checkValid($text) {
        $text = strtolower($text);
        $char = ['!', '?', '.', ',', '"', '\'', '(', ')', '-', '_', '/'];
        $text = str_replace($char, ' ', $text);
        $text .= ' ';

        $keywords = [
            'exchange',
            'criptomoeda',
            'bitcoin',
            'ethereum',
            'ripple',
            'btc',
            'eth',
            'xrp',
            'blockchain',
            ' ico ',
            ' icos ',
            'mercado cripto',
            'binance',
            'bitmex',
            'bitfinex',
            'coinbase',
            'foxbit',
            ' cripto ',
            ' crypto ',
            'altcoins',
            ' pos  ',
            ' pow ',
            'market cap',
            'marketcap',
            'monero',
            'xmr',
            'mimblewimble',
            'airdrop',
            'ltc',
            'bch',
            'trx',
            ' stable coins ',
            'satoshi nakamoto',
            'satoshinakamoto'
        ];

        $valid = false;

        foreach ($keywords as $v) {
            if (stripos($text, $v) !== false) {
                $valid = true;
            }
        }
        return $valid;
    }

}
