# QR Codes

A library that allows to easily interact with the [PHP QR Code Library](http://phpqrcode.sourceforge.net/) from Code Igniter.

## Installation

1. [Get Sparks](http://getsparks.org/install).
2. In a terminal, `cd` to your project root and type `php tools/spark install qr`.

## Usage

First, the Library needs to be loaded:

 - Add `qr` to your autoload: `$autoload['sparks'] = array('qr/0.0.1');`
 - Load the Library on demand:` $this->load->spark('qr/0.0.1');`

Then, you can configure the Library by either setting your `config` or creating a `config` and passing it to `initialize`, such as:

    $config = array('outputToBrowser' => TRUE, 'margin' => 1);
    $this->qr->initialize($config);

The available configs are as follows:

 - `outputToBrowser` - if set to true, headers will be sent to the browser to display a PNG, if you want to display more content than only the QR code, save it to disk and display it with a `<img>` tag
 - `errorCorrectionLevel` - sets the error correction level, valid values are `L`, `M`, `Q` and `H`, for more information, see [here](http://en.wikipedia.org/wiki/QR_code#Error_correction)
 - `matrixPointSize` - size in pixels of each points in the matrix, between 1 and 10
 - `margin` - size of the white border around the QR code

Here's the Library interface:
 - `$this->qr->initialize($config(s));` - can take no, 1 or many config arrays to set up the Library
 - `$this->qr->clear();` - clears the raw data to encode
 - `$this->qr->set_errorCorrectionLevel($level);` - manually set the error correction level
 - `$this->qr->set_matrixPointSize($size);` - manually set the matrix point size in pixels
 - `$this->qr->set_margin($size);` - manually set the size of the white border
 - `$this->qr->set_data($content);` - content to be encoded
 - `$this->qr->set_filename($filename);` - sets the file name where the QR code should be stored (if not set, the file is not saved to disk)
 - `$this->qr->createEncoder();` - called automatically when encoding if required, creates the QR encoder
 - `$this->qr->encodePNG($content[optional]);` - will encode `$content` and do the appropriate operations based on the config

## License

All of qr_spark is licensed under the MIT license except the content of the `vendor` folder which provides its own license.

Copyright (c) 2012 Eric Martel emartel@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
