
# Lauquiz

Make & Play Quiz WebApp, built in Laravel for Mobile Web Application Course at Harbour Space University

## Features

- Play a quiz, answering its questions

- See your results, how many answers are correct

- See the scoreboard of a quiz

- Create a quiz, create questions and answers for it

- Upload and use photos in questions

## Some extras

- Creates answered quizzes and answered questions when playing a quiz

- Check if a quiz is a draft, using a dispatched job and deleting cache (of the quizzes list) after updates the quiz

## Installation

First make sure you have php and composer installed

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

5. Migrate and seed the database

```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
```

## Authors

- [@humbertoyusta](https://www.github.com/humbertoyusta)

