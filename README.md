# Book net Backend

## How to run

1. Install composer on your system.
2. Go to project directory.
3. Run `composer install` to install packages.

The project runs on docker, so you need docker installed on your os. Then, run `./vendor/bin/sail up -d` to run containers. Now the backend ready on **localhost** port **80**.

### Sail Commands

| Command                      | Description                                            |
| ---------------------------- | ------------------------------------------------------ |
| sail up -d                   | Run server and containers                              |
| sail artisan migrate:refresh | Migrate tables and delete all data                     |
| sail db:seed                 | Seeding Database                                       |
| sail artisan route:list      | Show route table                                       |
| sail down                    | Shutdown server and containers                         |
| sail down -v                 | Shutdown server and containers and also remove volumes |

> All `sail` keyword in the table actually is `./vendor/bin/sail`.

### Pgadmin

The pgadmin runs on `localhost:5051`. Enter `pgadmin@pgadmin.org` for email and `admin` for password. To connect postgres to pgadmin, create new server.

> For creating new server, follow these steps:
>
> 1. Select New Server
> 2. In **General** tab and in **name** field enter a name for your server (e.g. booknet)
> 3. In **Connection** tab:
>     - Host name: `booknet_pgsql_1`
>     - Maintenance Database: `booknet`
>     - Username and Password: `admin`
>     - Check Save password checkbox
> 4. Click the blue **Save** button

The tables can be found in `Server > booknet > Databases > booknet > Schemas > Tables`.
