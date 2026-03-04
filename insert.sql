INSERT INTO admin (username,password)
VALUES ("giannis","1");


INSERT INTO rescuer (username_resc, password_resc, name, latitude, longitude)
VALUES ('giannis', '2', 'John Doe', 38.2766684, 21.7514926),
       ('kostas', '3', 'Jane Doe', 38.289182, 21.795689),
       ('maria', '4', 'Jane Doe', 40.289182, 40.795689);


INSERT INTO civilian (username_civ, password_civ, phone_number, name,last_name)
VALUES 
('user1', 'pass1', '123-456-7890', 'John','Doe'),
('user2', 'pass2', '234-567-8901', 'Jane','Smith'),
('user3', 'pass3', '345-678-9012', 'Alice','Johnson'),
('user4', 'pass4', '456-789-0123', 'Bob','Brown'),
('user5', 'pass5', '567-890-1234', 'Carol','Davis');

INSERT INTO offers (civilian_username, announcement_id, item_id, quantity, status,created_date, accepted_date, completed_date)
VALUES 
('user1', 1, 62, '5 units', 'Pending', CURRENT_TIMESTAMP, NULL, NULL),
('user2', 2, 64, '3 pieces', 'Accepted','2024-07-13 10:30:00' ,'2024-07-25 10:30:00', NULL),
('user1', 3, 72, '10 kg', 'Completed','2024-07-13 10:30:00' ,'2024-07-20 14:00:00', '2024-07-22 09:15:00'),
('user2', 1, 74, '2 sets', 'Pending', CURRENT_TIMESTAMP, NULL, NULL),
('user1', 4, 81, '7 boxes', 'Accepted','2024-07-26 12:00:00' ,'2024-07-28 08:45:00', NULL),
('user2', 2, 104, '4 units', 'Completed','2024-07-23 11:00:00' ,'2024-07-26 12:00:00', '2024-07-27 16:30:00'),
('user1', 3, 57, '20 liters', 'Pending', CURRENT_TIMESTAMP, NULL, NULL),
('user2', 5, 32, '15 pieces', 'Accepted', '2024-07-23 11:00:00','2024-07-29 11:00:00', NULL),
('user1', 6, 37, '12 kg', 'Completed', '2024-07-29 11:00:00','2024-07-30 13:20:00', '2024-08-01 17:45:00'),
('user2', 4, 36, '8 sets', 'Pending', CURRENT_TIMESTAMP, NULL, NULL);


INSERT INTO new_request (username, item_name, people_count, request_date, status_request, acceptance_date, completion_date) 
VALUES 
('user1', 'Chocolate', 5, '2023-07-01', 'PENDING', NULL, NULL),
('user1', 'Bread', 10, '2023-07-05', 'ACCEPTED', '2023-07-06', NULL),
('user2', 'Fakes', 3, '2023-07-10', 'COMPLITED', '2023-07-11', '2023-07-15'),
('user2', 'Canned', 7, '2023-07-20', 'PENDING', NULL, NULL),
('user2', 'Water', 2, '2023-07-25', 'ACCEPTED', '2023-07-26', NULL),
('user1', 'Fruits', 4, '2023-08-01', 'COMPLITED', '2023-08-02', '2023-08-10');

INSERT INTO rescuer_items (rescuer_username, item_id, quantity) 
VALUES 
    ('giannis', 101, '10'),
    ('giannis', 102, '5');
   