# php-todolist

Deployed to AWS Elastic Beanstalk -> [App](http://phptodolist-env-1.eba-7qkqyyb3.us-east-2.elasticbeanstalk.com/)

## Local development setup

1. Install PostgreSQL and create user `postgres` with password `postgres`

2. Create `php-todolist` PostgreSQL database with `postgres` user (`createdb php-todolist` works if you have the PGUSER and PGPASSWORD environment variables both set to `postgres`)

### Run

```bash
./dev.sh
```
