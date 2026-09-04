DROP TABLE events;
CREATE Table events(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    start DATETIME NOT NULL,
    end DATETIME NOT NULL
);

INSERT INTO events (name, description, start, end)
VALUES ("evenement de test", "", "2026-09-04 10:00:00", "2026-09-04 11:00:00");
INSERT INTO events (name, description, start, end)
VALUES ("evenement de test 2", "", "2026-09-05 10:00:00", "2026-09-05 11:00:00");
INSERT INTO events (name, description, start, end)
VALUES ("evenement de test 3", "", "2026-09-04 10:00:00", "2026-09-04 11:00:00");