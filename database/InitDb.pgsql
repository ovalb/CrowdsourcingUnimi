\i CreateDatabase.pgsql
\i CreateKeywords.pgsql
\i CreateFunctions.pgsql
\i CreateViews.pgsql
\i CreateAssigner.pgsql

CREATE SCHEMA crypto; 
CREATE EXTENSION pgcrypto WITH SCHEMA crypto;

-- insert admin
select insert_user('admin', 'password', 'admin');
