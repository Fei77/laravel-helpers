# LaravelHelpers

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require hifisaputra/laravel-helpers
```

## Usage

``` php
// Image helpers
$image = Helpers::image($request->imagefile)

/**
 * Change directory path using laravel's helper functions
 *
 * Parameters:
 * (string) - default (public_path())
 *
 */
$image->path(storage_path())

/**
 * Change the folder path
 *
 * Parameters:
 * (string) - default ('images')
 */
$image->folder('images/profile')  

/**
 * Add encoding
 *
 * Parameters:
 * (string) Here's a list of encoding format
 * supported by [Intervention Image](http://image.intervention.io)
 *
 *  jpg — return JPEG encoded image data
 *  png — return Portable Network Graphics (PNG) encoded image data
 *  gif — return Graphics Interchange Format (GIF) encoded image data
 *  tif — return Tagged Image File Format (TIFF) encoded image data
 *  bmp — return Bitmap (BMP) encoded image data
 *  ico — return ICO encoded image data
 *  psd — return Photoshop Document (PSD) encoded image data
 *  webp — return WebP encoded image data
 *  data-url — encode current image data in data URI scheme (RFC 2397)
 *
 * (integer) Define the quality of the encoded image optionally.
 * Data ranging from 0 (poor quality, small file) to 100 (best quality, big file).
 */
$image->encode('jpg', 95)

/**
 * Add prefix to filename
 *
 * Parameters:
 * (string)
 */
$image->prefix('user-')

/**
 * Save the image
 * Return the image's name
 */
$image->save();

dd($image) // '/images/profile/user-5a9d24bb389ae.jpg'


/**
 * Save the image with thumbnail
 * Return an array of the image's name and the thumbnail's name
 */
$image->saveWithThumbnail();

dd($image)
/**
 * [
 *	'originalName' : '/images/profile/user-5a9d24bb389ae.jpg',
 *  'thumbnailName' : '/images/profile/user-5a9d24bb389ae_tn.jpg'
 * ]
 */

// Delete helpers
/**
* Delete file from the given path
* @param $path can be array of strings or just a string.
*/
Helpers::delete($path);

//Config writer
/**
 * Write laravel config file 
 * 
 * credit: https://github.com/daftspunk/laravel-config-writer
 * 
 * @param array
 */
Helpers::config()->write(['app.locale' => 'en']);
```

## Example
```php
public function store(Request $request)
{
  $blog = new Blog();
  $blog->user_id = Auth::user()->id;
  if ($request->image) {

    $image = Helpers::image($request->image)->folder('images/blogs')->encode('jpg', 80)->saveWithThumbnail();
	  // the image files will be saved inside public/images/blogs
    
    $blog->originalUrl = $image['originalName'];
    $blog->previewUrl = $image['thumbnailName'];
  }

  $blog->fill($request->translations);
  $blog->save();
}
```


## Contributing

- [hifisaputra][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/fei77/laravel-helpers.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/fei77/laravel-helpers/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/fei77/laravel-helpers.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/fei77/laravel-helpers.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/fei77/laravel-helpers.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/fei77/laravel-helpers
[link-travis]: https://travis-ci.org/fei77/laravel-helpers
[link-scrutinizer]: https://scrutinizer-ci.com/g/fei77/laravel-helpers/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/fei77/laravel-helpers
[link-downloads]: https://packagist.org/packages/fei77/laravel-helpers
[link-author]: https://github.com/hifisaputra
[link-contributors]: ../../contributors
