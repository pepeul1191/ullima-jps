-- migrate:up

CREATE TABLE 'users' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'user'	VARCHAR(45) NOT NULL,
	'pass'	VARCHAR(45) NOT NULL,
  'email'	VARCHAR(45) NOT NULL,
  'profile'	VARCHAR(45),
  'picture'	VARCHAR(150),
  'reset_key'	VARCHAR(45),
  'activation_key'	VARCHAR(45),
  'teacher_id'	INTEGER,
  FOREIGN KEY(`teacher_id`) REFERENCES 'teachers' ( 'id' ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS 'users';