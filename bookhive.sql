-- Run Apache and MySQL on XAMPP
-- Go to loalhost/phpmyadmin
-- Click on New
-- Database name: bookhive
-- Click on Create button
-- Go to SQL tab to write queries

-- Books Table **************************************************************************************************************************************
CREATE TABLE Books(
    book_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    author varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    genre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    checked_out_by varchar(255)
);

INSERT INTO Books (author, title, genre, description)
VALUES ('John Doe', 'The Great Adventure', 'Adventure', 'A thrilling journey across the world.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Jane Smith', 'Mystery at Midnight', 'Mystery', 'A suspenseful tale of crime and investigation.');

INSERT INTO Books (author, title, genre, description)
VALUES ('George Orwell', '1984', 'Dystopian Fiction', 'A classic novel depicting a totalitarian society.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Ernest Hemingway', 'The Sun Also Rises', 'Fiction', 'A story of disillusioned expatriates in post-World War I Europe.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Agatha Christie', 'And Then There Were None', 'Mystery', 'Ten strangers trapped on an isolated island face a deadly game of deception.');

-- Members Table **************************************************************************************************************************************

CREATE TABLE Members(
    member_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL -- For "next steps" we need to mention that we will encrypt passwords for security reasons
);

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Alice', 'Johnson', 'alice.johnson@example.com', 'password123');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Robert', 'Davis', 'robert.davis@example.com', 'secret123');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Michelle', 'Anderson', 'michelle.anderson@example.com', 'mysecurepass');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Daniel', 'Wilson', 'daniel.wilson@example.com', 'pass123word');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Sophia', 'Brown', 'sophia.brown@example.com', 'strongpassword');

-- Librarians Table **************************************************************************************************************************************

CREATE TABLE Librarians(
    librarian_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL -- For "next steps" we need to mention that we will encrypt passwords for security reasons
); 

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Ethan', 'Smith', 'ethan.smith@example.com', 'securepass123');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Olivia', 'Taylor', 'olivia.taylor@example.com', 'password789');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Liam', 'Wilson', 'liam.wilson@example.com', 'strongpass321');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Ava', 'Anderson', 'ava.anderson@example.com', 'mypassword456');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Noah', 'Brown', 'noah.brown@example.com', 'password1234');
