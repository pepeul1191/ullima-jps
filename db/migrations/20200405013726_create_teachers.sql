-- migrate:up

CREATE TABLE 'teachers' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL,
  'email'	VARCHAR(40) NOT NULL,
  'picture'	VARCHAR(150) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'teachers';