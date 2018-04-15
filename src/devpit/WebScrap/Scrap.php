<?php

/*
Copyright 2018 Pietro Verga
(https://pitfactory.it)
This file is part of WebScrap.
WebScrap is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
WebScrap is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.
You should have received a copy of the GNU General Public License along with GramBot.
If not, see <http://www.gnu.org/licenses/>.
*/

namespace devpit\ScrapPage;

class Scrap
{
    public $site;
    public $fpoint;
    public $spoint;
    public $postaction;

    public function __construct($site, $check = false)
    {
        if ($check == true) {
            $checksite = @file_get_contents($site);
            if ($checksite) {
                $this->site = $site;

                return true;
            } else {
                throw new Exception('Invalid site');
            }
        } else {
            return true;
        }
    }

    public function setFirstPoint($fpoint)
    {
        $this->fpoint = $fpoint;

        return true;
    }

    public function setSecondPoint($spoint)
    {
        $this->spoint = $spoint;

        return true;
    }

    public function scrapSite()
    {
        if ($this->fpoint and $this->spoint) {
            $ch = @file_get_contents($this->site);
            if ($ch) {
                $pos1 = strpos($ch, $this->fpoint);
                $pos2 = strpos($ch, $this->spoint, $pos1);
                $get = substr($ch, $pos1, $pos2 - $pos1);

                return $get;
            } else {
                throw new Exception('Invalid site');
            }
        } else {
            throw new Exception('Point not assigned');
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
