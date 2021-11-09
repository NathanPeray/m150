DROP DATABASE IF EXISTS natework;

CREATE DATABASE natework;
USE natework;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    prename VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    hash CHAR(128) NOT NULL,
    salt CHAR(16) NOT NULL
);
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_fk INT NOT NULL,
    ident VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);
CREATE TABLE timestamps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_fk INT NOT NULL,
    task_fk INT NOT NULL,
    day DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    stampin TIME NOT NULL,
    stampout TIME
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_fk INT NOT NULL,
    timegoal TIME DEFAULT "8:00",
    dailyincome FLOAT DEFAULT 122.10,
    expenses1 FLOAT DEFAULT 19,
    expenses2 FLOAT DEFAULT 11.50,
    holidays INT DEFAULT 25,
    checkout TIME DEFAULT "17:00"
);
CREATE TABLE holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_FK INT NOT NULL,
    day DATE NOT NULL
);
ALTER TABLE users
ADD CONSTRAINT email_uq UNIQUE (email);

ALTER TABLE tasks
ADD FOREIGN KEY (user_fk) REFERENCES users(id);

ALTER TABLE timestamps
ADD FOREIGN KEY (task_fk) REFERENCES tasks(id),
ADD FOREIGN KEY (user_fk) REFERENCES users(id);

ALTER TABLE settings
ADD FOREIGN KEY (user_fk) REFERENCES users(id);

ALTER TABLE holidays
ADD FOREIGN KEY (user_fk) REFERENCES users(id);
