# CloudBox API SDK

## Installation

```shell
composer require muhammadsaim/cloudbox-api-sdk
```

## Get API Key

Register or Login at CloudBox Developer Portal, Create an App -> Copy your API Key.

###Namespaces & Required Files

```php
require_once "./vendor/autoload.php";
use MuhammadSaim;
```

## Albums
+ List All Albums 

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$albums = $cloudbox->albums();

echo "<pre>";

var_dump($albums);
```
if you wish to display specific pages of the albums then pass number of page to `albums` method

```php

$albums = $cloudbox->albums(3);

```

## Create album

+ Create new album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$createAlbum = $cloudbox->createAlbum('FOLDER_NAME');

echo "<pre>";

var_dump($createAlbum);
```

If you want to create sub-album or folder in the specific album just pass the `parent_id` of the folder or album.

```php

$createAlbum = $cloudbox->createAlbum('SUBFOLDER_NAME', 1);

```

## Update Album
+ Update Specific Album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$updateAlbum = $cloudbox->updateAlbum('NEW_NAME', 52);

echo "<pre>";

var_dump($updateAlbum);
```

## Delete Album
+ Delete Specific Album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$deleteAlbum = $cloudbox->deleteAlbum(52);

echo "<pre>";

var_dump($deleteAlbum);
```

## Files

+ List all files from album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$files = $cloudbox->files(2);

echo "<pre>";

var_dump($files);
```

To paginate files you have to pass second parameter as `page_number` with your `album_id`
```php

$files = $cloudbox->files(2, 4);

```

## Image Upload

+ Upload Image to your album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$imageUpload = $cloudbox->imageUpload('ABSOLUTE_IMAGE_PATH', '2');

echo "<pre>";

var_dump($imageUpload);
```

## Video Upload

+ Upload Video to your album

```php
<?php
$cloudbox = new CloudBox( "TOKEN", 'BASE_URL' );

$videoUpload = $cloudbox->videoUpload('ABSOLUTE_VIDEO_PATH', '2');

echo "<pre>";

var_dump($videoUpload);
```

