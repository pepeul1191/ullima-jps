-- migrate:up

CREATE TABLE 'sections' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'code' INTEGER NOT NULL,
	'period'	VARCHAR(6) NOT NULL,
  'teacher_id' INTEGER NOT NULL,
  'student_id' INTEGER NOT NULL,
  FOREIGN KEY(`teacher_id`) REFERENCES 'teachers' ( 'id' ) ON DELETE CASCADE, 
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE 
);

-- migrate:down

DROP TABLE IF EXISTS 'sections';