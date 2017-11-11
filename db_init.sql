DROP TABLE gallery;
DROP TABLE user;
DROP TABLE tag;
DROP TABLE pic;
DROP TABLE user_gallery;


CREATE TABLE gallery
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  description VARCHAR(1000)
);

CREATE TABLE user
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  email VARCHAR(255),
  password VARCHAR(1000)
);

CREATE TABLE tag
(
  tag_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  tag_name VARCHAR(1000)
);

CREATE TABLE pic
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  tag VARCHAR(255),
  title VARCHAR(255),
  picture_blob BLOB,
  thumbnail_blob BLOB
);

CREATE TABLE user_gallery
(
  user_id INT,
  gallery_id INT
);