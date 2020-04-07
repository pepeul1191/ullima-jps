-- migrate:up

INSERT INTO users (id, user, pass, email, profile, reset_key, activation_key, teacher_id) VALUES 
  (1, 'jovaldiv', 'dcsEfivNzQxQBj1wZbLaeGNgmTTi5o48MC0tM2UuHcQ=', 'jovaldiv@ulima.edu.pe', 'teacher', '', '', 1);

-- migrate:down

DELETE FROM users;    
DELETE FROM sqlite_sequence where name='users';