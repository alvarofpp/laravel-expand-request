# expand-request
[![Packagist Version](https://img.shields.io/packagist/v/alvarofpp/expand-request)](https://packagist.org/packages/alvarofpp/expand-request)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/alvarofpp/laravel-expand-request/blob/master/LICENSE)

A package to make it easy to manipulate your requests and more.

## Contents
  - [Install](#install)
  - [Usage](#usage)
  - [Contributing](#contributing)

## Install
Install via composer:
```bash
composer require alvarofpp/expand-request
```

## Usage
This package currently contains:
- Checks whether the request url belongs to a pattern.
- Add url parameters to be validated.
  - Rename url parameters.
- Remove extra parameters.

### Checks whether the current request url belongs to a pattern
You can check whether the request url belongs to a url pattern or route pattern. Use this methods:
- `is_url($patterns, $request = null)`
- `is_route($patterns, $request = null)`

By default, `$request` is the current request.

Example: You can use this to activate a class in your menu, such as:
```html
<li class="nav-item ">
    <a class="{{ is_route('courses.index') ? 'open' : '' }}" href="{{route('courses.index')}}">
        <span class="item-name">Show courses</span>
    </a>
</li>
```

These methods accept a array as the first parameter, so that you can check various patterns:
```html
<li class="nav-item ">
    <a class="{{ is_route(['courses.index', 'contents.index',]) ? 'open' : '' }}" href="{{route('courses.index')}}">
        <span class="item-name">Show courses</span>
    </a>
</li>
```

Another example is that you can use it to check where the user is coming from:
```php
<?php
// ...
$previousUrl = app('request')->create(url()->previous());
if (is_url('courses/create', $previousUrl)) {
    // Do something...
}
```

### UrlParameters
Add url parameters to be validated in your FormRequest.
Use the trait `UrlParameters` in your FormRequest, such as:
```php
<?php
namespace App\Http\Requests\Course;

use Alvarofpp\ExpandRequest\Traits\UrlParameters;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    use UrlParameters;
    // ...
}
```

If your url is `[GET] /courses/{course}`,
you can validate the parameter `course` in your `$rules`:

```php
<?php
// ...
public function rules()
{
    return [
        'course' => ['required', 'exists:courses,id',],
    ];
}
// ...
```

#### Rename url parameters
If you want rename the parameter, just declare the variable `$renameUrlParameters`.
Example: you have a url `/courses/{course}/contents/{content}/videos/{video}`, you can use:

```php
<?php
namespace App\Http\Requests\Course;

use Alvarofpp\ExpandRequest\Traits\UrlParameters;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    use UrlParameters;
    
    protected $renameUrlParameters = [
        'course_id',
        'content_id',
        'video_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => ['required', 'exists:courses,id',],
            'content_id' => ['required', 'exists:contents,id',],
            'video_id' => ['required', 'exists:videos,id',],
        ];
    }
    // ...
}
```
Declare the index in the array to decide which parameter will change:
```php
<?php
// ...
protected $renameUrlParameters = [
    0 => 'course_id',
    // 1 => 'content_id',
    2 => 'video_id',
];
// ...
```

### Remove extra parameters
Use the trait `RemoveExtraParameters` in your FormRequest to remove extra parameters:
```php
<?php
namespace App\Http\Requests\Course;

use Alvarofpp\ExpandRequest\Traits\RemoveExtraParameters;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    use RemoveExtraParameters;
    // ...
}
```

This trait uses the `$accept` property. By default the values in `$accept` are a merge of the keys present in `rules()` and `attributes()`. You can specify which fields are accepted in your FormRequest specifying in `$accept`.
```php
<?php
namespace App\Http\Requests\Course;

use Alvarofpp\ExpandRequest\Traits\RemoveExtraParameters;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    use RemoveExtraParameters;
    
    protected $accept = [
        'field_1', 'field_2',
    ];
    // ...
}
```

In this example, if you receive a request such as `{"field_1": 50, "field_2": 100, "extra_field": 1}`, the `extra_field` will be removed from that request.

## Contributing
Contributions are more than welcome. Fork, improve and make a pull request. For bugs, ideas for improvement or other, please create an [issue](https://github.com/alvarofpp/laravel-expand-request/issues).
