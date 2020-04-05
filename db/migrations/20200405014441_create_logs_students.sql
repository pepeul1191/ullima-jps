-- migrate:up

CREATE TABLE 'logs_students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'time' DATETIME NOT NULL,
	'action'	VARCHAR(45) NOT NULL,
  'student_id'	INTEGER,
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS 'logs_students';