
CREATE DATABASE mydb;

use mydb;

CREATE TABLE "PhoneNumber" (
  "id" INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  "number" INT NOT NULL,
  "condition" INT NOT NULL,
  "createdAt" datetime NOT NULL,
  "updatedAt" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "locationid" INT NOT NULL
);



