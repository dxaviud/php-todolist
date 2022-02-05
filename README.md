# php-todolist

## Setup

1. Install PostgreSQL and create user `postgres` with password `postgres`

2. Create `php-todolist` database in postgres (`createdb -U postgres php-todolist`)

3. In php.ini-development:
    - uncomment `extension=pgsql`
    - set `extension_dir` properly (`extension_dir = "ext"` on windows)

4. Set environment variable `PHPRC="<path/to/php.ini-development>"` in `~/.bashrc` or similar

5. Restart shell (or run `source ~/.bashrc` if using bash)

6. Create tables (`php -c "$PHPRC" scripts/initialize_database.php`)

## Run

`php -c "$PHPRC" -S localhost:8080`

