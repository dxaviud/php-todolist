# php-todolist

## Setup

1. Install PostgreSQL and create user `postgres` with password `postgres`

2. Create `php-todolist` PostgreSQL database with `postgres` user (`createdb php-todolist` works if you have the PGUSER and PGPASSWORD environment variables both set to `postgres`)

3. In php.ini-development, set `extension_dir` properly (`extension_dir = "ext"` on windows)

4. Run migrations (`./migrations.sh`)

## Run

```bash
./dev.sh
```
