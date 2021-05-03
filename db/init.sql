--- Users ---

CREATE TABLE users (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL,
	username TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL
);

INSERT INTO users (id, name, username, password) VALUES (1, 'Edward Zhang', 'edward', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (2, 'Cindy Qian', 'cindy', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (3, 'Scott Xu', 'scott', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (4, 'Devis Lai', 'devis', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (5, 'Jason Liang', 'jason', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (6, 'Karen Kuang', 'karen', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (7, 'Eric Zheng', 'eric', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (8, 'Olivia Gao', 'olivia', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (9, 'Bowen Li', 'bowen', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (10, 'Yolanda Peng', 'yolanda', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (11, 'Henry Xiao', 'henry', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (12, 'Jessica Tang', 'jessica', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey
INSERT INTO users (id, name, username, password) VALUES (13, 'Yu Cao', 'yu', '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'); -- password: monkey


--- Sessions ---

CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE,
  last_login   TEXT NOT NULL,

  FOREIGN KEY(user_id) REFERENCES users(id)
);


--- Groups ---

CREATE TABLE groups (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL UNIQUE
);

INSERT INTO groups (id, name) VALUES (1, 'alumnus');
INSERT INTO groups (id, name) VALUES (2, 'student');


--- Group Membership ---

CREATE TABLE memberships (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  group_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,

  FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO memberships (group_id, user_id) VALUES (1, 1);
INSERT INTO memberships (group_id, user_id) VALUES (1, 2);
INSERT INTO memberships (group_id, user_id) VALUES (1, 3);
INSERT INTO memberships (group_id, user_id) VALUES (1, 4);
INSERT INTO memberships (group_id, user_id) VALUES (1, 5);
INSERT INTO memberships (group_id, user_id) VALUES (1, 6);
INSERT INTO memberships (group_id, user_id) VALUES (1, 7);
INSERT INTO memberships (group_id, user_id) VALUES (1, 8);
INSERT INTO memberships (group_id, user_id) VALUES (1, 9);
INSERT INTO memberships (group_id, user_id) VALUES (1, 10);
INSERT INTO memberships (group_id, user_id) VALUES (1, 11);
INSERT INTO memberships (group_id, user_id) VALUES (1, 12);
INSERT INTO memberships (group_id, user_id) VALUES (2, 13);


--- Informations ---

CREATE TABLE informations (
	id	            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id         INTEGER NOT NULL,
	first_name     	TEXT NOT NULL,
  last_name     	TEXT NOT NULL,
  graduation_year INTEGER NOT NULL,
  university      TEXT NOT NULL,
  major           TEXT NOT NULL,
  country         TEXT NOT NULL,
  contact         TEXT NOT NULL,

  FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (1, 1, 'Edward', 'Zhang', 2019, 'Oxford University', 'Mathematics', 'UK', 'edward@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (2, 2, 'Cindy', 'Qian', 2018, 'New York University', 'Education', 'US', 'cindy@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (3, 3, 'Scott', 'Xu', 2016, 'Stanford University', 'Mathematics', 'US', 'scott@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (4, 4, 'Devis', 'Lai', 2020, 'University of Southern California', 'Industrial & Systems Engineering', 'US', 'devis@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (5, 5, 'Jason', 'Liang', 2016, 'Hong Kong University', 'Biomedicine', 'Hong Kong, China', 'jason@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (6, 6, 'Karen', 'Kuang', 2018, 'Cornell University', 'Information Science', 'US', 'karen@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (7, 7, 'Eric', 'Zheng', 2015, 'Imperial College London', 'Physics', 'UK', 'eric@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (8, 8, 'Olivia', 'Gao', 2020, 'New York University', 'Film & TV Production', 'US', 'olivia@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (9, 9, 'Bowen', 'Li', 2017, 'Carleton College', 'Mathematics', 'US', 'bowen@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (10, 10, 'Yolanda', 'Peng', 2017, 'New York University', 'Education', 'US', 'yolanda@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (11, 11, 'Henry', 'Xiao', 2015, 'University of Toronto', 'Mathematics', 'Canada', 'henry@school.edu');
INSERT INTO informations (id, user_id, first_name, last_name, graduation_year, university, major, country, contact) VALUES (12, 12, 'Jessica', 'Tang', 2019, 'Hong Kong University', 'Mathematics', 'Hong Kong, China', 'jessica@school.edu');
