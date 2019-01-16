CREATE VIEW admin_view AS 
	SELECT a.id, u.username, u.password 
	FROM users u JOIN admin a on u.id = a.user_id;

CREATE VIEW worker_view AS
	SELECT w.id, u.username, u.password
	FROM users u JOIN worker w on u.id = w.user_id;

CREATE VIEW requester_view AS
	SELECT r.id, u.username, u.password, r.has_permission
	FROM users u JOIN requester r ON u.id = r.user_id;
