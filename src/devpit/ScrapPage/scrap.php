<?php
namespace devpit\ScrapPage;
class Scrap {

  public $site;
  public $fpoint;
  public $spoint;
  public $postaction;
  public function __construct($site) {
    $checksite = file_get_contents($site);
    if($checksite) {
      $this->site = $site;
      return 'Class initialized';
    } else {
      exit('Error: site non valid');
    }
  }
  public function setFirstPoint($fpoint) {
    $this->fpoint = $fpoint;
    return 'First point to scrap assigned';
  }
  public function setSecondPoint($spoint) {
    $this->spoint = $spoint;
    return 'Second point to scrap assigned';
  }
  public function scrapSite() {
    if($this->fpoint and $this->spoint) {
      $ch = file_get_contents($this->site);
      $pos1 = strpos($ch, $this->fpoint);
      $pos2 = strpos($ch, $this->spoint, $pos1);
      $get = substr($ch,$pos1,$pos2-$pos1);
      return $get;
    } else {
      exit('Error: point not assigned');
    }
  }
}
 ?>
