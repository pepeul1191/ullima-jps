-- migrate:up

CREATE TABLE 'logs' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'time' DATETIME NOT NULL,
	'action'	VARCHAR(45) NOT NULL,
  'user_id'	INTEGER,
  FOREIGN KEY(`user_id`) REFERENCES 'users' ( 'id' ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS 'logs';