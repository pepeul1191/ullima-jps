-- migrate:up

CREATE TABLE 'teachers_sections' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'teacher_id' INTEGER NOT NULL,
  'section_id' INTEGER NOT NULL,
  FOREIGN KEY(`section_id`) REFERENCES 'sections' ( 'id' ) ON DELETE CASCADE, 
  FOREIGN KEY(`teacher_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE 
);

-- migrate:down

DROP TABLE IF EXISTS 'teachers_sections';