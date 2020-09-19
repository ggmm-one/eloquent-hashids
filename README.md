# Eloquent Hashids

Do you want to hide your primary keys from your Laravel app urls?

Add hashids to your Eloquent models on-the-fly. No need for extra database columns.

## How to use

Use the HasHashid trait on your models

```php
use Ggmm\Model\HasHashid;

class Car extends Model
{
    use HasHashid;
}

# now your model has a hashid attribute

$car->hashid;

# to find the id from a hashid use decodeHashid

$car->decodeHashid('hashidhere');

```

Note: your model's primary key must be a positive integer

## Routing

To use the hashid on your model's routing use the trait HashidRoutable.

```php
use Ggmm\Model\HasHashid;
use Ggmm\Model\HashidRoutable

class Car extends Model
{
    use HasHashid;
    use HashidRoutable
}

# Now instead of a url like https://example.org/car/11/edit
# You will have a url like https://example.org/car/xLq/edit

```

## Advanced

If you want to customise the hashid generation, set the hashidGenerator on the constructor. For options see [vinkla/hashids](https://github.com/vinklahashids).

```php
use Hashids\Hashids;

class Car extends Model
{
    use HasHashid;

    public function __constructor()
    {
        $this->hashidGenerator = new Hashids('myhashsaltgoeshere');
    }
}

```

Note: the hashing on this library has no cryptographic value. Do not use to implement any security scheme.
