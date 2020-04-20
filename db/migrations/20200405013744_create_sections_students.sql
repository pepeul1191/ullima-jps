-- migrate:up

CREATE TABLE 'sections_students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'points' INTEGER,
  'section_id' INTEGER NOT NULL,
  'student_id' INTEGER NOT NULL,
  FOREIGN KEY(`section_id`) REFERENCES 'sections' ( 'id' ) ON DELETE CASCADE, 
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE 
);

-- migrate:down

DROP TABLE IF EXISTS 'sections_students';