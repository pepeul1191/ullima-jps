-- migrate:up

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

-- migrate:down

DROP VIEW IF EXISTS vw_students_sections;