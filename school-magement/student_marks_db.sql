-- Drop existing database if needed
DROP DATABASE IF EXISTS happy_conn;
CREATE DATABASE happy_db;
USE happy_db;

-- Students Table
CREATE TABLE happy_students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  student_id VARCHAR(20) UNIQUE NOT NULL,
  class VARCHAR(50) NOT NULL,
  other_details VARCHAR(255),
  password VARCHAR(255) NOT NULL
);

-- Teachers Table
CREATE TABLE happy_teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  subject VARCHAR(50) NOT NULL,
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Admins Table
CREATE TABLE happy_admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Marks Table
CREATE TABLE happy_marks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(20) NOT NULL,
  subject VARCHAR(50) NOT NULL,
  marks DECIMAL(5,2) NOT NULL,
  entry_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  teacher_id INT NOT NULL,
  CONSTRAINT fk_marks_student FOREIGN KEY (student_id) REFERENCES happy_students(student_id) ON DELETE CASCADE,
  CONSTRAINT fk_marks_teacher FOREIGN KEY (teacher_id) REFERENCES happy_teachers(id) ON DELETE CASCADE
);

-- Modules Table (For Permissions & Role-Based Access Control)
CREATE TABLE happy_modules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  module_name VARCHAR(255) UNIQUE NOT NULL,
  description TEXT DEFAULT NULL,
  parent_module_id INT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  other_details VARCHAR(255),
  CONSTRAINT fk_module_parent FOREIGN KEY (parent_module_id) REFERENCES happy_modules(id) ON DELETE SET NULL
);

-- User Modules Table (For Role-Based Access Control)
CREATE TABLE happy_user_modules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  module_id INT NOT NULL,
  user_type ENUM('student', 'teacher', 'admin') NOT NULL,
  CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES happy_students(id) ON DELETE CASCADE,
  CONSTRAINT fk_module FOREIGN KEY (module_id) REFERENCES happy_modules(id) ON DELETE CASCADE
);
