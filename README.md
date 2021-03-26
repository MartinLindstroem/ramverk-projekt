# Ramverk Project

## Installation guide
1. Clone the repo
2. Install the dependencies
console```
    cd ramverk1-project
    composer install
    ```
3. Create cache directory
console```
    mkdir cache
    mkdir cache/anax
    ```
4. Create database file and create tables.
```console
    chmod 777 data/
    touch data/db.sqlite
    sqlite3 data/db.sqlite # Exit out immediately, ctrl-d
    chmod 666 data/db.sqlite

    sqlite3 data/db.sqlite < sql/ddl/ddl.sql
```