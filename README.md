# CloudBox API SDK

## Installation

```shell
composer require muhammadsaim/cloudbox-sdk
```

## Get API Key

Go the the CloudBox Developer Portal and create an App and copy your API Key.

## Albums

```php
require_once "./vendor/autoload.php";

use MuhammadSaim\CloudBox\CloudBox;

$cloudbox = new CloudBox( "API_KEY" );

$albums = $cloudbox->albums();
```

## Create album

Create new album

```php
require_once "./vendor/autoload.php";

use MuhammadSaim\CloudBox\CloudBox;
require_once "./vendor/autoload.php";

use MuhammadSaim\CloudBox\CloudBox;

$cloudbox = new CloudBox( "API_KEY" );

$album = $cloudbox->createAlbum("My Album");
$cloudbox = new CloudBox( "API_KEY" );

$album = $cloudbox->createAlbum("My Album");
```

If you wanna create sub album or folder just pass the parent id of the folder or album.

```php
require_once "./vendor/autoload.php";

use MuhammadSaim\CloudBox\CloudBox;

$cloudbox = new CloudBox( "API_KEY" );

$album = $cloudbox->createAlbum("My Album", 1);
```
