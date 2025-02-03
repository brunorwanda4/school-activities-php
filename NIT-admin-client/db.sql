-- Create users table
CREATE TABLE IF NOT EXISTS ineza_tblusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    other_user_details VARCHAR(255)
);

-- Create admin table (Added email)
CREATE TABLE IF NOT EXISTS ineza_tbladmin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create temperature data table
CREATE TABLE IF NOT EXISTS ineza_tbltemperature (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_point VARCHAR(255) NOT NULL,
    temperature DECIMAL(5,2) NOT NULL,
    humidity DECIMAL(5,2) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES ineza_tblusers(id) ON DELETE CASCADE
);

-- Insert sample users
INSERT INTO ineza_tblusers (username, email, password, other_user_details) 
VALUES ('user1', 'user1@example.com', 'hashedpassword123', 'Other details here');

-- Insert sample admin
INSERT INTO ineza_tbladmin (username, email, password) 
VALUES ('admin', 'admin@example.com', 'hashedadminpassword');

-- Insert sample temperature data
INSERT INTO ineza_tbltemperature (data_point, temperature, humidity, user_id) 
VALUES ('Point A', 22.5, 60.2, 1);
