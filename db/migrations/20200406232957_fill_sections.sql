-- migrate:up

INSERT INTO sections ('code','period', 'course_id') VALUES 
(601, '2020-I', 1), 
(602, '2020-I', 1), 
(402, '2020-I', 2), 
(702, '2020-I', 3);

-- migrate:down

DELETE FROM sections;    
DELETE FROM sqlite_sequence where name='sections';