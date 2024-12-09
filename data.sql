create database package_manager;
CREATE TABLE autors(
	id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) not null,
    email varchar(30) not null
);
CREATE TABLE packages(
	id int PRIMARY KEY AUTO_INCREMENT,
    title varchar(100) not null,
    description varchar(255) NOT null,
    creation_date DATE not null
    -- autor_id int,
    -- FOREIGN key(autor_id) REFERENCES autors(id)
);
CREATE TABLE versions(
	id int PRIMARY KEY AUTO_INCREMENT,
    Version_Number text not null,
    description varchar(255) NOT null,
    Release_Date DATE not null,
    package_id int,
    FOREIGN key(package_id) REFERENCES packages(id)
);
CREATE TABLE tags(
	id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(30) not null
);
CREATE TABLE Dependencies(
	id int PRIMARY KEY AUTO_INCREMENT,
    parent_package_id INT,
    child_package_id INT,
    FOREIGN key(parent_package_id) REFERENCES packages(id),
    FOREIGN key(child_package_id) REFERENCES packages(id)
);
CREATE TABLE packages_tags(
	id int PRIMARY KEY AUTO_INCREMENT,
    tag_id INT,
    package_id INT,
    FOREIGN key(tag_id) REFERENCES tags(id),
    FOREIGN key(package_id) REFERENCES packages(id)
);
CREATE TABLE autors_packages(
	id int PRIMARY KEY AUTO_INCREMENT,
    autor_id INT,
    package_id INT,
    FOREIGN key(autor_id) REFERENCES autors(id),
    FOREIGN key(package_id) REFERENCES packages(id)
);
-- SELECT * from packages INNER JOIN autors on packages.autor_id = autors.id;
INSERT INTO Autors (name, email) VALUES
('Alice Smith', 'alice@example.com'),
('Bob Johnson', 'bob@example.com'),
('Charlie Brown', 'charlie@example.com');
INSERT INTO Packages (title, Description, Creation_Date) VALUES
('Library A', 'A utility library for math', '2023-01-01'),
('Framework B', 'A web development framework', '2023-06-01'),
('Tool C', 'A CLI tool for developers', '2024-02-15'),
('Plugin D', 'A plugin for integrating payment gateways into e-commerce applications.', '2023-11-10'),
('Module E', 'A Python module for data manipulation and machine learning workflows.', '2023-08-20'),
('Package F', 'A collection of JavaScript utilities for web performance optimization, including lazy loading and caching mechanisms.', '2024-05-05'),
('SDK G', 'A software development kit "SDK" that simplifies building mobile applications with native features.', '2023-12-25'),
('Tool H', 'A GUI tool for managing databases, including support for backup, migration, and performance optimization.', '2024-01-15'),
('Library I', 'A powerful image processing library that provides utilities for resizing, cropping, and transforming images.', '2023-09-03'),
('Framework J', 'An open-source framework for rapid development of real-time applications like chat and live streaming.', '2024-03-30');
INSERT INTO Versions (Version_Number, Release_Date, Package_ID) VALUES
('1.0', '2023-01-15', 1),
('1.1', '2023-05-10', 1),
('1.0', '2023-06-30', 2),
('2.0', '2024-03-01', 2),
('1.0', '2024-02-20', 3),
('1.2', '2023-08-05', 1),
('2.0', '2023-07-01', 2),
('1.1', '2024-03-15', 2),
('1.0', '2023-09-10', 4),
('2.0', '2024-06-10', 4),
('1.1', '2024-02-05', 5),
('2.0', '2024-07-25', 6),
('1.0', '2023-12-15', 7),
('1.2', '2024-04-25', 8),
('1.0', '2024-01-30', 9),
('3.0', '2024-08-01', 10);
INSERT INTO Autors_Packages (Autor_ID, Package_ID) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(1, 5),
(2, 6),
(3, 7),
(2, 8),
(2, 9),
(3, 10);
INSERT INTO Tags (Name) VALUES
('Web Development'),
('Mathematics'),
('Command Line Tools'),
('Mobile Development'),
('Data Science'),
('Performance Optimization'),
('E-Commerce'),
('Real-Time Applications'),
('Image Processing');
INSERT INTO Packages_Tags (Package_ID, Tag_ID) VALUES
(1, 2),
(2, 1),
(3, 3),
(4, 1),
(5, 2),
(6, 4),
(7, 5),
(8, 6),
(9, 3),
(10, 1);
INSERT INTO Dependencies (parent_Package_ID, Child_Package_ID) VALUES
(2, 1),
(3, 2),
(4, 5),
(7, 8),
(6, 7),
(9, 10);