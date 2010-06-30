# About

phreshpress is a PHP library that interacts with Cafepress's API (version 3).

Currently in supports adding images (not SVGs) to Cafepress products.  By defaulte
the library can position the image on the Front Center of the product.  If
you know the products other positions, the library can handle that too.

# Architecture

The library has been built from a strict OOP perspective.

Currently there are three main 'cafepress objects': User, Product, Design,
and Designer (it applies a design to a product).  Additionally, there is a Store object that mainly acts
as a factory and simplifies the instantiation of User, Product, Design,
and Designer objects.

To each Cafepress Object corresponds a 'Request' object and a 'Response'
object.  The Request object handles the actual POST or GET request
to the API, and the Response object encapsulates the API's XML response.

Hopefully, this architecture is robust enough to make it easy to implement
new additions and extensions.

# Example

Here is an example:

`$email = 'my@emailaddress.com';
$password = 'mysekritpassword';
$appKey = 'appkeyfromcafepress';
$storeName = 'storename';
$imgPath = '/image.png';
$merchandiseId = '2';

$cp = new Cafepress_Store( $appKey, $storeName);
$cp->authenticate( $email, $password );

//echo out the marketURI for that product and it's design
echo $cp->createProductWithFrontDesign( $merchandiseId, $imgPath );`


# License

GNU Public License v3

# TODO

Add more documentation, although IMHO, the code is fairly clean and
straightforward.

# Future

It's probably best to fork this project if you want to work on it
further.  I'm making it available to the public in hopes that someone
can take it further than I currently want to.

