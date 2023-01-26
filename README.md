# 🪄 Ladmin Engine


# 🚀 Quickstart

Follow the steps below to get started faster! Add the repository by running the command below.

```bash
$ composer require hexters/ladmin
```

Follow the installation
```
$ php artisan ladmin:install
```

Run migrate and seed, to install ladmin database tables
```bash
$ php artisan migrate --seed
```

# 🗂️ Custom Namespaces

To call `view`, `language`, `config`, and `component` file, you need to add the prefix of module's name eg `blog`, see example below.

Calling View:
```php
  view('blog::article.index');
```

Calling Lang:
```php
  __('blog::error.auth.message');

  trans('blog::error.auth.message');

  Lang::get('blog::error.auth.message');
```

Calling Config:
```php
  config('blog.name')
```

For component view, if you have component named `\Modules\Blog\View\Components\Input` class, then the way to call it by running.
```html
  <x-blog-input />
```
# 👓 Ladmin Awesome
Get modules & template collections in [Ladmin Awesome](https://github.com/hexters/ladmin-awesome)

# 📖 Documentation
View complete [Documentation here](https://github.com/hexters/ladmin-engine/wiki)
