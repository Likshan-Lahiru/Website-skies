DROP DATABASE IF EXISTS skies;
CREATE DATABASE IF NOT EXISTS skies;
USE skies;

CREATE TABLE IF NOT EXISTS promotions(
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         userEmail VARCHAR(50)
    );
