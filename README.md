# WebScrap [![StyleCI](https://styleci.io/repos/110293825/shield?branch=master)](https://styleci.io/repos/110293825)

**Do Web-Scrap simply!**

## Initialize the class

```
require_once 'vendor/autoload.php';
$yourSite = '';
$session = new \devpit\ScrapPage\Scrap($yourSite);
```


## Setting points

```
$session->setFirstPoint(''); // setting first point
$session->setSecondPoint(''); //setting second point
```

## Scrap

```
$session->scrapSite();
```
It returns a string
