CREATE TABLE schema_migrations (version varchar(255) primary key);
CREATE TABLE 'students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL,
  'email'	VARCHAR(40) NOT NULL,
  'picture'	VARCHAR(150) NOT NULL,
  'tw_id' VARCHAR(30) NOT NULL,
	'tw_pass'	VARCHAR(30) NOT NULL
);
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
CREATE TABLE 'logs' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'time' DATETIME NOT NULL,
	'action'	VARCHAR(45) NOT NULL,
  'user_id'	INTEGER,
  FOREIGN KEY(`user_id`) REFERENCES 'users' ( 'id' ) ON DELETE CASCADE
);
CREATE TABLE 'teachers' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL,
  'email'	VARCHAR(40) NOT NULL,
  'picture'	VARCHAR(150) NOT NULL
);
CREATE TABLE 'courses' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(45) NOT NULL,
	'code'	INTEGER NOT NULL
);
CREATE TABLE 'sections' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'code' INTEGER NOT NULL,
	'period'	VARCHAR(6) NOT NULL,
  'course_id' INTEGER NOT NULL,
  FOREIGN KEY(`course_id`) REFERENCES 'courses' ( 'id' ) ON DELETE CASCADE
);
CREATE TABLE 'sections_students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'section_id' INTEGER NOT NULL,
  'student_id' INTEGER NOT NULL,
  FOREIGN KEY(`section_id`) REFERENCES 'sections' ( 'id' ) ON DELETE CASCADE,
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE
);
CREATE TABLE 'logs_students' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'time' DATETIME NOT NULL,
	'action'	VARCHAR(45) NOT NULL,
  'student_id'	INTEGER,
  FOREIGN KEY(`student_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE
);
CREATE TABLE 'teachers_sections' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'teacher_id' INTEGER NOT NULL,
  'section_id' INTEGER NOT NULL,
  FOREIGN KEY(`section_id`) REFERENCES 'sections' ( 'id' ) ON DELETE CASCADE,
  FOREIGN KEY(`teacher_id`) REFERENCES 'students' ( 'id' ) ON DELETE CASCADE
);
CREATE VIEW vw_students_sections AS
  SELECT
    S.period AS period,
    TS.section_id AS section_id,
    S.code AS section_code,
	C.code AS course_code,
    C.name AS course_name,
    STU.code AS student_code,
    STU.name AS student_name,
    STU.picture AS picture,
    STU.email AS student_email,
    STU.tw_id AS tw_id,
    STU.tw_pass AS tw_pass
  FROM sections S
  INNER JOIN teachers_sections TS ON S.id = TS.section_id
  INNER JOIN courses C ON S.course_id = C.id
  INNER JOIN sections_students SCT ON SCT.section_id = S.id
  INNER JOIN students STU ON SCT.student_id = STU.id;
-- Dbmate schema migrations
INSERT INTO schema_migrations (version) VALUES
  ('20200405000053'),
  ('20200405000659'),
  ('20200405013648'),
  ('20200405013726'),
  ('20200405013732'),
  ('20200405013738'),
  ('20200405013744'),
  ('20200405014441'),
  ('20200406215208'),
  ('20200406232508'),
  ('20200406232957'),
  ('20200406235605'),
  ('20200406235610'),
  ('20200407025949'),
  ('20200409012755');
