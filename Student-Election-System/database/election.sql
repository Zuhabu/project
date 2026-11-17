CREATE DATABASE IF NOT EXISTS student_election;

USE student_election;

-- ===========================
-- Students Table
-- ===========================

CREATE TABLE students(

id INT AUTO_INCREMENT PRIMARY KEY,

student_id VARCHAR(30) UNIQUE NOT NULL,

fullname VARCHAR(100) NOT NULL,

email VARCHAR(100) UNIQUE NOT NULL,

department VARCHAR(100) NOT NULL,

academic_year VARCHAR(20) NOT NULL,

password VARCHAR(255) NOT NULL,

otp VARCHAR(10),

verified ENUM('Yes','No') DEFAULT 'No',

has_voted ENUM('Yes','No') DEFAULT 'No',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ===========================
-- Admin Table
-- ===========================

CREATE TABLE admins(

id INT AUTO_INCREMENT PRIMARY KEY,

username VARCHAR(50),

password VARCHAR(255)

);

-- Default Admin
-- Password = admin123

INSERT INTO admins(username,password)

VALUES(

'admin',

'$2y$10$0YmFjKJr9eS9mH8M6H7zPeM6jU6z8D1aXr1zqk2C8P5e9YlKQkD5O'

);

-- ===========================
-- Candidates Table
-- ===========================

CREATE TABLE candidates(

id INT AUTO_INCREMENT PRIMARY KEY,

name VARCHAR(100),

department VARCHAR(100),

position VARCHAR(100),

manifesto TEXT,

photo VARCHAR(255)

);

-- Sample Candidates

INSERT INTO candidates(name,department,position,manifesto,photo)

VALUES

('Ahmed Niyas','Information Technology','President',

'Improve student welfare',

'candidate1.jpg'),

('Fathima Mariyam','English','Vice President',

'Promote leadership',

'candidate2.jpg'),

('Mohamed Ameen','Tamil','Secretary',

'Digital communication',

'candidate3.jpg');

-- ===========================
-- Votes
-- ===========================

CREATE TABLE votes(

id INT AUTO_INCREMENT PRIMARY KEY,

student_id INT,

candidate_id INT,

vote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(student_id)

REFERENCES students(id),

FOREIGN KEY(candidate_id)

REFERENCES candidates(id)

);