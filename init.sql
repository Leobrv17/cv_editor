CREATE TABLE IF NOT EXISTS profil
(
    UserId      INT AUTO_INCREMENT PRIMARY KEY,
    FirstName   VARCHAR(50) NOT NULL,
    LastName    VARCHAR(50) NOT NULL,
    Birthday    DATE,
    PhoneNumb   VARCHAR(15),
    City        VARCHAR(50),
    Country     VARCHAR(50) NOT NULL,
    Permis      VARCHAR(10),
    Description VARCHAR(250)
);
CREATE TABLE IF NOT EXISTS experience
(
    ExpId          INT AUTO_INCREMENT PRIMARY KEY,
    UserId         INT          NOT NULL,
    ExpName        VARCHAR(100) NOT NULL,
    JobPosition    VARCHAR(100),
    ExpStart       DATE,
    ExpEnd         DATE,
    Localisation   VARCHAR(100),
    ExpDescription VARCHAR(500),
    FOREIGN KEY (UserId) REFERENCES profil (UserId)
);
CREATE TABLE IF NOT EXISTS skills
(
    SkillId        INT AUTO_INCREMENT PRIMARY KEY,
    UserId         INT          NOT NULL,
    SkillName      VARCHAR(100) NOT NULL,
    ExpDescription VARCHAR(500),
    FOREIGN KEY (UserId) REFERENCES profil (UserId)
);
CREATE TABLE IF NOT EXISTS certification
(
    CertificationId INT AUTO_INCREMENT PRIMARY KEY,
    UserId          INT          NOT NULL,
    CertName        VARCHAR(100) NOT NULL,
    CertDate        DATE,
    CertDescription VARCHAR(500),
    FOREIGN KEY (UserId) REFERENCES profil (UserId)
);