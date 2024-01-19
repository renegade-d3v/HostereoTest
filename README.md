1. Clone repo:
```bash
git clone https://github.com/renegade-d3v/HostereoTest
```
2. Create .env
```bash
cd HostereoTest
```
```bash
cp .env.example .env
```
3. Migrate tables and seed
```bash
php artisan migrate --seed
```
4. Check test
```bash
php artisan test
```

All routes require header `Content-Language` it can be `ua`, `en`, `ru`
