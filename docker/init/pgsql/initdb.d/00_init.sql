create database ala;
psql ala -c 'create extension hstore;'
create user ala with encrypted password 'dev';
grant all privileges on database ala to ala;
ALTER USER ala WITH SUPERUSER;
CREATE EXTENSION hstore;
