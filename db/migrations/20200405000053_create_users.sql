-- migrate:up

CREATE TABLE 'users' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'user'	VARCHAR(45) NOT NULL,
	'pass'	VARCHAR(45) NOT NULL,
  'email'	VARCHAR(45) NOT NULL,
  'profile'	VARCHAR(45) NOT NULL,
  'reset_key'	VARCHAR(45) NOT NULL,
  'activation_key'	VARCHAR(45) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'users';