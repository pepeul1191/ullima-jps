-- migrate:up

CREATE TABLE 'sections' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'code' INTEGER NOT NULL,
	'period'	VARCHAR(6) NOT NULL,
  'course_id' INTEGER NOT NULL,
  FOREIGN KEY(`course_id`) REFERENCES 'courses' ( 'id' ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS 'sections';