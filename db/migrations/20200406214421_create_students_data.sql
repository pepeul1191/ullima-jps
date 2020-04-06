-- migrate:up

INSERT INTO students ('name', 'code','email', 'picture', 'tw_id', 'tw_pass') VALUES ('Jose Jesus Valdivia Caballero', 20051191, '20051191@aloe.ulima.edu.pe', 'https://lh6.googleusercontent.com/-f4Psb7IsNc0/AAAAAAAAAAI/AAAAAAAAAAA/AAKWJJPAIlJpYqG9GKNRs_YQXGZa9GZV1g/photo.jpg', '1 424 610 2463', 'gau643');

-- migrate:down

DELETE FROM students;    
DELETE FROM sqlite_sequence where name='students';