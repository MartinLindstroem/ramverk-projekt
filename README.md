# Ramverk Project
[![CircleCI](https://circleci.com/gh/MartinLindstroem/ramverk-projekt.svg?style=svg)](https://circleci.com/gh/MartinLindstroem/ramverk-projekt)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MartinLindstroem/ramverk-projekt/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/MartinLindstroem/ramverk-projekt/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/MartinLindstroem/ramverk-projekt/badges/build.png?b=main)](https://scrutinizer-ci.com/g/MartinLindstroem/ramverk-projekt/build-status/main)

## Installation guide
1. Clone the repo
2. Install the dependencies
```bash
    cd ramverk-projekt
    make install
```
<!-- 3. Create cache directories in root of project
```bash
    mkdir cache
    mkdir cache/anax
``` -->
4. Create database file and create tables.
```bash
    chmod 777 data/
    touch data/db.sqlite
    sqlite3 data/db.sqlite # Exit out immediately, ctrl-d
    chmod 666 data/db.sqlite

    sqlite3 data/db.sqlite < sql/ddl/ddl.sql
```