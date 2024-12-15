-- Active: 1733928635054@@127.0.0.1@3306

create DATABASE if NOT EXISTS itthink;
use itthink;

CREATE TABLE IF NOT EXISTS Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)

CREATE TABLE IF NOT EXISTS  Freelancers(
    id_freelancer INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE
)

CREATE TABLE IF NOT EXISTS  Categories(
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)


CREATE TABLE IF NOT EXISTS Subcategories(
    id_subcategory INT AUTO_INCREMENT PRIMARY KEY,
    id_category INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_category) REFERENCES Categories(id_category) ON DELETE CASCADE
)

CREATE TABLE IF NOT EXISTS Projects(
    id_project INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    discription TEXT NOT NULL,
    id_user INT NOT NULL,
    id_subcategory INT,
    id_category INT,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_subcategory) REFERENCES Subcategories(id_subcategory) ON DELETE SET NULL,
    FOREIGN KEY (id_category) REFERENCES Categories(id_category) ON DELETE SET NULL
)



CREATE TABLE IF NOT EXISTS Offres(
    id_offre INT AUTO_INCREMENT PRIMARY KEY,
    id_project INT NOT NULL,
    id_freelancer INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    deadline DATE NOT NULL
)


CREATE TABLE IF NOT EXISTS Testimonials(
    id_testimonial INT AUTO_INCREMENT PRIMARY KEY,
    user_comment INT NOT NULL,
    id_user INT NOT NULL,
    id_freelancer INT NOT NULL,
    FOREIGN KEY  (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_freelancer) REFERENCES Freelancers(id_freelancer) ON DELETE CASCADE
)


CREATE TABLE IF NOT EXISTS Skill(
    id_skill INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
)

CREATE TABLE IF NOT EXISTS Freelancer_Skill(
    id_freelancer_skill INT PRIMARY KEY AUTO_INCREMENT,
    id_skill INT NOT NULL,
    id_freelancer INT NOT NULL,
    FOREIGN KEY (id_freelancer) REFERENCES Freelancers(id_freelancer) ON DELETE CASCADE,
    FOREIGN KEY (id_skill) REFERENCES Skill(id_skill) ON DELETE CASCADE
)


INSERT INTO Users ( name, email, password) VALUES ('mohamed karroumi', 'mkarroumi@gmail.com', '123456789');

INSERT INTO Freelancers (id_user) VALUES (1);


DELETE FROM Freelancers WHERE Freelancers.id_freelancer != 1;

INSERT INTO Categories (name) VALUES ('design');

INSERT INTO Subcategories (name, id_category) VALUES ("UI Design", 1);

INSERT INTO Subcategories (name, id_category) VALUES ("UX Design", 1);
INSERT INTO Subcategories (name, id_category) VALUES ("FX Design", 1);

INSERT INTO Projects (title, discription, id_user, id_category) VALUES ('FUT', 'brief 7', 1, 1);
INSERT INTO Projects (title, discription, id_user, id_subcategory) VALUES ('Quiz','brief 7', 1, 2);

INSERT INTO Offres (id_project, id_freelancer, price, deadline) VALUES (1, 1, 552.22, '2025-01-01');

INSERT INTO Testimonials(user_comment, id_user, id_freelancer) VALUES ('very goood', 1, 1);

INSERT INTO Skill (name) VALUES ('HTML');
INSERT INTO Freelancer_Skill(id_skill, id_freelancer) VALUES (1, 1);



DELETE FROM Offres WHERE Offres.id_offre!=1;

ALTER TABLE Freelancer_skill CHANGE COLUMN id_user id_skill INT NOT NULL;

SELECT CONSTRAINT_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_NAME = 'Subcategories' AND COLUMN_NAME = 'id_category';

--subcategories_ibfk_1

ALTER TABLE Subcategories DROP FOREIGN KEY subcategories_ibfk_1;

ALTER TABLE Subcategories ADD CONSTRAINT fk_subcategories_category
FOREIGN KEY (id_category) REFERENCES Categories(id_category) ON DELETE CASCADE;

SELECT projects.title, categories.id_category
from projects
INNER join categories
ON projects.id_category = categories.id_category;

SELECT projects.title, subcategories.name
from projects
OUTER JOIN subcategories
ON projects.id_subcategory = subcategories.id_subcategory;

DROP TABLE User_Skill;
DELETE FROM projects where id_project = 4;
SELECT * FROM projects;
