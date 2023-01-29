# ⚙️ Ladmin Engine

Follow the steps below to get started faster! Add the repository by running the command below.

```bash
$ composer require ladmin/engine
```

Follow the installation
```
$ php artisan ladmin:install --and=[OPOTIONS]
```

Run migrate and seed, to install ladmin database tables
```bash
$ php artisan migrate --seed
```

# Managing assets

Install node module pacakge
```bash
npm install -s @hexters/ladmin-vite-input
```

Open `vite.config.js` in your project and follow the instruction below.

```js

. . . 
import ladminViteInputs from '@hexters/ladmin-vite-input'
. . .

export default defineConfig({
    plugins: [
        laravel({
            input: ladminViteInputs([
                'resources/css/app.css',
                'resources/js/app.js'
            ]),
            refresh: true,
        }),
    ],
});


```
# 📖 Documentation
View complete [Documentation here](https://github.com/hexters/ladmin/wiki)
