-- migrate:up

CREATE TABLE 'students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL,
  'email'	VARCHAR(40) NOT NULL,
  'picture'	VARCHAR(110) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'students';