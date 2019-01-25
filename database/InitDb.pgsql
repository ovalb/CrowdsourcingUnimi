\i CreateDatabase.pgsql
\i InsertKeywords.pgsql
\i InsertUser.pgsql
\i CreateViews.pgsql
\i AssignTaskAffinity.pgsql
\i AssignScoreWorker.pgsql

CREATE SCHEMA crypto; 
CREATE EXTENSION pgcrypto WITH SCHEMA crypto;

-- insert admin
select insert_user('admin', 'password', 'admin');
