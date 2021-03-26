# Ramverk Project

## Installation guide
1. Clone the repo
2. Install the dependencies
```console
    /ramverk-projekt$ cd ramverk-projekt
    /ramverk-projekt$ composer install
```
3. Create cache directory
```console
    /ramverk-projekt$ mkdir cache
    /ramverk-projekt$ mkdir cache/anax
```
4. Create database file and create tables.
```
    /ramverk-projekt$ chmod 777 data/
    /ramverk-projekt$ touch data/db.sqlite
    /ramverk-projekt$ sqlite3 data/db.sqlite # Exit out immediately, ctrl-d
    /ramverk-projekt$ chmod 666 data/db.sqlite

    /ramverk-projekt$ sqlite3 data/db.sqlite < sql/ddl/ddl.sql
```