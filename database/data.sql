CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    phonenum VARCHAR(20),
    email VARCHAR(255),
    age INT NOT NULL,
    village VARCHAR(100),
    village_head VARCHAR(100),
    business_category VARCHAR(50),
    business_name VARCHAR(100),
    picture_path VARCHAR(255),
    social_media_url VARCHAR(255),
    document_path VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
