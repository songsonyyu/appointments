CREATE TABLE appoint (id INTEGER PRIMARY KEY AUTOINCREMENT, patientName varchar(100) NOT NULL, reason varchar(100) NOT NULL, startTime varchar(100) NOT NULL, endTime varchar(100) NOT NULL);
INSERT INTO appoint (patientName, reason, startTime, endTime) VALUES ('John Doe', 'MRI', '8:00AM', '9:00AM');
