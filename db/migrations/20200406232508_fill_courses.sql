-- migrate:up

INSERT INTO courses ('code','name') VALUES 
(650005, 'PROGRAMACIÓN ORIENTADA A OBJETOS'), 
(650014, 'LENGUAJES DE PROGRAMACIÓN'),
(650022, 'PROGRAMACIÓN WEB');

-- migrate:down

DELETE FROM courses;    
DELETE FROM sqlite_sequence where name='courses';