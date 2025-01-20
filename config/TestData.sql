INSERT INTO users (id, name, type) VALUES (1, 'John Doe', 'customer'), (2, 'Jane Smith', 'pharmacist');

INSERT INTO medications (user_id, name, started_at, dosage, note) 
VALUES (1, 'Paracetamol', '2025-01-01 10:00:00', 500, 'Take after meals');
