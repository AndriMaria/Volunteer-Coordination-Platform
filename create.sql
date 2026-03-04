DROP DATABASE IF EXISTS naturaldisaster;
CREATE DATABASE naturaldisaster;
USE naturaldisaster;

CREATE TABLE admin (
    username VARCHAR(30),
    password VARCHAR(30),
    PRIMARY KEY(password)
);

CREATE TABLE rescuer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username_resc VARCHAR(30) NOT NULL,
    password_resc VARCHAR(30) NOT NULL,
    name VARCHAR(50) NOT NULL,
    latitude DOUBLE NOT NULL,    
    longitude DOUBLE NOT NULL    
);




CREATE TABLE civilian (
    username_civ VARCHAR(30) PRIMARY KEY,
    password_civ VARCHAR(30),
    phone_number VARCHAR(30),
    name VARCHAR(30),
    last_name VARCHAR(30)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    quantity VARCHAR(50),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE announcement_items (
    announcement_id INT,
    item_id INT,
    PRIMARY KEY (announcement_id, item_id),
    FOREIGN KEY (announcement_id) REFERENCES announcements(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    civilian_username VARCHAR(30),
    announcement_id INT,
    item_id INT,
    quantity VARCHAR(50),
    status ENUM('Pending', 'Accepted', 'Completed') DEFAULT 'Pending',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	accepted_date TIMESTAMP NULL,
	completed_date TIMESTAMP NULL
    /*FOREIGN KEY (civilian_username) REFERENCES civilian(username_civ),
    FOREIGN KEY (announcement_id) REFERENCES announcements(id),
    FOREIGN KEY (item_id) REFERENCES items(id)*/
);

CREATE TABLE new_request (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    username varchar(30),
    item_name VARCHAR(30),
    people_count INT,
    request_date DATE,
    status_request ENUM('PENDING','ACCEPTED','COMPLITED') default 'PENDING',
    acceptance_date DATE,
    completion_date DATE,
   FOREIGN KEY (username) REFERENCES civilian(username_civ)
);

CREATE TABLE rescuer_items (
    rescuer_username VARCHAR(30) NOT NULL,
    item_id INT,
    name_item VARCHAR(255) NOT NULL,
    quantity VARCHAR(50)
    /*PRIMARY KEY (rescuer_username, item_id),
    FOREIGN KEY (rescuer_username) REFERENCES rescuer(username_resc) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE*/
);
