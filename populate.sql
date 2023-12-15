INSERT INTO profil (FirstName, LastName, Birthday, PhoneNumb, Email, City, Country, Permis, Description)
VALUES ('Jean', 'Dupont', '1990-01-01', '0123456789', 'jean.dupont@email.com', 'Paris', 'France', 'B',
        'Développeur logiciel expérimenté'),
       ('Marie', 'Curie', '1985-07-12', '0987654321', 'marie.curie@email.com', 'Lyon', 'France', 'B',
        'Chercheuse en chimie'),
       ('Ahmed', 'Benzema', '1988-03-15', '0567891234', 'ahmed.benzema@email.com', 'Marseille', 'France', 'B',
        'Ingénieur en informatique'),
       ('Sarah', 'Leclerc', '1992-11-08', '0678912345', 'sarah.leclerc@email.com', 'Nice', 'France', 'A',
        'Graphiste freelance');

INSERT INTO experience (UserId, ExpName, JobPosition, ExpStart, ExpEnd, Localisation, ExpDescription)
VALUES (1, 'Développeur chez TechCorp', 'Développeur Senior', '2015-01-01', '2020-12-31', 'Paris',
        'Développement de logiciels en Java et Python'),
       (2, 'Chercheur à l Université de Lyon', 'Chercheur principal', '2010-05-01', '2018-08-30', 'Lyon',
        'Recherche en chimie organique'),
       (3, 'Ingénieur systèmes', 'Ingénieur réseau', '2013-02-01', '2019-11-30', 'Marseille',
        'Maintenance et déploiement de réseaux informatiques'),
       (4, 'Freelance', 'Graphiste', '2014-07-01', '2015-08-02', 'Nice', 'Conception graphique pour clients variés');

INSERT INTO skills (UserId, SkillName, ExpDescription)
VALUES (1, 'Java', 'Expérience avancée en développement Java'),
       (1, 'Python', 'Automatisation et scripts en Python'),
       (2, 'Chimie organique', 'Spécialisation en chimie organique et pharmaceutique'),
       (3, 'Réseaux informatiques', 'Compétences en conception et gestion de réseaux'),
       (4, 'Design graphique', 'Expertise en Adobe Photoshop et Illustrator'),
       (4, 'Animation 3D', 'Création d animations 3D avec Blender');

INSERT INTO certification (UserId, CertName, CertDate, CertDescription)
VALUES (1, 'Certification Java Oracle', '2019-06-15', 'Certification professionnelle Java délivrée par Oracle'),
       (2, 'Doctorat en chimie', '2012-09-10', 'Doctorat obtenu à l Université de Lyon en chimie'),
       (3, 'Cisco Certified Network Associate (CCNA)', '2016-05-20', 'Certification CCNA pour compétences réseau'),
       (4, 'Certification Adobe Creative Suite', '2018-08-25',
        'Certification en design graphique avec Adobe Creative Suite');
