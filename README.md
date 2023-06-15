### Tasarım aşamasında 

Açık kaynak kodlu emlak sitesi yönetim paneli.

Paneli yapmak için FilamentPHP paketini kullandım.

Kurulum için izlenecek adımlar

- `cd <dizin adi>`
- `git clone https://github.com/gsarigul84/emlak .`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`

`.env` içerisinde bulunan veritabanı ayarları, site başlığı, site adresi gibi değerleri gerektiği gibi değiştirdikten sonra aşağıdaki işlemleri yapmanız gerekiyor
- `php artisan migrate`
- `php artisan tinker`

Açılan konsolda :
- `User::create(['name' => '<ad>', 'email' => <eposta>, 'password' => Hash::make('<sifre>'), 'is_admin' => true, 'active' => true]);`

Filament ayarları için https://filamentphp.com/

