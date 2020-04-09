-- migrate:up

CREATE VIEW vw_teachers_sections AS
 SELECT 
    S.period AS period,
	TEA.id AS teacher_id,
    TS.section_id AS section_id, 
    S.code AS section_code, 
	C.code AS course_code, 
    C.name AS course_name 
  FROM sections S
  INNER JOIN teachers_sections TS ON S.id = TS.section_id 
  INNER JOIN courses C ON S.course_id = C.id 
  INNER JOIN teachers TEA ON TS.teacher_id = TEA.id;

-- migrate:down

DROP VIEW IF EXISTS vw_teachers_sections;