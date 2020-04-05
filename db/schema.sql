CREATE TABLE schema_migrations (version varchar(255) primary key);
CREATE TABLE 'users' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'user'	VARCHAR(45) NOT NULL,
	'pass'	VARCHAR(45) NOT NULL,
  'email'	VARCHAR(45) NOT NULL,
  'profile'	VARCHAR(45) NOT NULL,
  'reset_key'	VARCHAR(45) NOT NULL,
  'activation_key'	VARCHAR(45) NOT NULL
);
CREATE TABLE 'logs' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'time' DATETIME NOT NULL,
	'action'	VARCHAR(45) NOT NULL,
  'user_id'	INTEGER,
  FOREIGN KEY(`user_id`) REFERENCES 'users' ( 'id' ) ON DELETE CASCADE
);
-- Dbmate schema migrations
INSERT INTO schema_migrations (version) VALUES
  ('20200405000053'),
  ('20200405000659');
