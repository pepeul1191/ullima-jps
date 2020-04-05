-- migrate:up

CREATE TABLE 'sections_students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'sectionr_id' INTEGER NOT NULL,
  'student_id' INTEGER NOT NULL,
  FOREIGN KEY(`sectionr_id`) REFERENCES 'sectionrs' ( 'id' ) ON DELETE CASCADE, 
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE 
);

-- migrate:down

DROP TABLE IF EXISTS 'sections_students';