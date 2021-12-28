CREATE USER pguser WITH PASSWORD 'pgpassword';

DROP DATABASE IF EXISTS symfony6_vue_amqp;

CREATE DATABASE symfony6_vue_amqp WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'C' LC_CTYPE = 'C';

ALTER DATABASE symfony6_vue_amqp OWNER TO pguser;
