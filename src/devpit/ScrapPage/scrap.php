<?php

namespace devpit\ScrapPage;

class scrap
{
    public $site;
    public $fpoint;
    public $spoint;
    public $postaction;

    public function __construct($site)
    {
        $checksite = file_get_contents($site);
        if ($checksite) {
            $this->site = $site;

            return 'Class initialized';
        } else {
            exit('Error: site non valid');
        }
    }

    public function setFirstPoint($fpoint)
    {
        $this->fpoint = $fpoint;

        return 'First point to scrap assigned';
    }

    public function setSecondPoint($spoint)
    {
        $this->spoint = $spoint;

        return 'Second point to scrap assigned';
    }

    public function scrapSite()
    {
        if ($this->fpoint and $this->spoint) {
            $ch = file_get_contents($this->site);
            $pos1 = strpos($ch, $this->fpoint);
            $pos2 = strpos($ch, $this->spoint, $pos1);
            $get = substr($ch, $pos1, $pos2 - $pos1);

            return $get;
        } else {
            exit('Error: point not assigned');
        }
    }

    public function postAction($post)
    {
        $post = json_encode($post);
        $this->postaction = $post;
    }

    public function resultPostAction()
    {
        $jpostaction = json_decode($this->postaction);
        $request = '';
        foreach ($jpostaction as $k => $v) {
            $request .= $k.'='.urlencode($v).'&';
        }
        rtrim($request, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->site);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_exec($ch);
        curl_close($ch);

        return $ch;
    }
}
