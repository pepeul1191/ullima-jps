-- migrate:up

CREATE TABLE 'courses' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'courses';