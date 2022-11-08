
# Lauquiz

Simple quiz application, built in laravel in Mobile Web Application Course for Harbour Space University
## Authors

- [@humbertoyusta](https://www.github.com/humbertoyusta)


## Installation

First sure you have php and composer installed

1. Clone the project and cd into the folder

```bash
  git clone https://github.com/humbertoyusta/lauquiz
  cd lauquiz
```

2. Copy .env.example to .env

```bash
  cp .env.example .env
```

3. Run composer install
    
```bash
  composer install
```

4. Build the container
    
```bash
  ./vendor/bin/sail build --no-cache
```

4. Run the container
    
```bash
  ./vendor/bin/sail up -d
```

5. Migrate the database

```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
```