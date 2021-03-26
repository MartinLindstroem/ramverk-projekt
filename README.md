# Ramverk Project

## Installation guide
1. Clone the repo
2. Install the dependencies
```bash
    cd ramverk-projekt
    composer install
```
3. Create cache directories in root of project
```bash
    mkdir cache
    mkdir cache/anax
```
4. Create database file and create tables.
```bash
    chmod 777 data/
    touch data/db.sqlite
    sqlite3 data/db.sqlite # Exit out immediately, ctrl-d
    chmod 666 data/db.sqlite

    sqlite3 data/db.sqlite < sql/ddl/ddl.sql
```

[![CircleCI](https://circleci.com/gh/MartinLindstroem/ramverk-projekt.svg?style=svg)](https://circleci.com/gh/MartinLindstroem/ramverk-projekt)