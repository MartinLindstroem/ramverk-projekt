--
-- Creating tables.
--



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id"       INTEGER PRIMARY KEY NOT NULL,
    "email"    VARCHAR(60) UNIQUE NOT NULL,
    "username" VARCHAR(30) UNIQUE NOT NULL,
    "password" TEXT,
    "avatar"   TEXT,
    "created"  TIMESTAMP,
    "updated"  DATETIME,
    "deleted"  DATETIME,
    "active"   DATETIME
);

--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id"          INTEGER PRIMARY KEY NOT NULL,
    "title"       TEXT,
    "content"     TEXT,
    "posted_by"   VARCHAR(30) NOT NULL,
    "posted"      TIMESTAMP,
    "updated"     DATETIME,
    "deleted"     DATETIME,

    FOREIGN KEY ("posted_by") REFERENCES User("username")
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id"          INTEGER PRIMARY KEY NOT NULL,
    "question_id" INTEGER NOT NULL,
    "content"     TEXT,
    "posted_by"   VARCHAR(30) NOT NULL,
    "posted"      TIMESTAMP,
    "updated"     DATETIME,
    "deleted"     DATETIME,

    FOREIGN KEY ("question_id") REFERENCES Question("id"),
    FOREIGN KEY ("posted_by") REFERENCES User("username")
);

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id"          INTEGER PRIMARY KEY NOT NULL,
    "question_id" INTEGER,
    "answer_id"   INTEGER,
    "content"     TEXT,
    "posted_by"   VARCHAR(30) NOT NULL,
    "posted"      TIMESTAMP,
    "updated"     DATETIME,
    "deleted"     DATETIME,

    FOREIGN KEY ("question_id") REFERENCES Question("id"),
    FOREIGN KEY ("answer_id") REFERENCES Answer("id"),
    FOREIGN KEY ("posted_by") REFERENCES User("username")
);

--
-- Table Tag
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id"       INTEGER PRIMARY KEY NOT NULL,
    "tag_name" VARCHAR(30) UNIQUE
);

--
-- Table Tag2Question
--
DROP TABLE IF EXISTS Tag2Question;
CREATE TABLE Tag2Question (
    "id"          INTEGER PRIMARY KEY NOT NULL,
    "tag_name"    VARCHAR(20),
    "question_id" INTEGER,

    FOREIGN KEY ("tag_name") REFERENCES Tag("tag_name"),
    FOREIGN KEY ("question_id") REFERENCES Question("id")
);