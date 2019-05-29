
CREATE DATABASE mydb;

use mydb;

CREATE TABLE "PhoneNumber"(
  "id" INT NOT NULL PRIMARY KEY, 
  "number" varchar(60) NOT NULL,
  "status" varchar(50),
  "bodyText" varchar(250),
  "createdAt" datetime NOT NULL,
  "updatedAt" datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "serviceHostPort" INT NOT NULL
);



