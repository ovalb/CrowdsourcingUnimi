CREATE OR REPLACE FUNCTION tasks_percentage(_campaign integer) RETURNS real AS $$
	DECLARE
		_total_task_num integer;
		_valid_task_num integer;
		_result real;
	BEGIN
		SELECT COUNT(*) INTO _total_task_num FROM task WHERE campaign = _campaign;
	   	SELECT COUNT(*) INTO _valid_task_num FROM task WHERE campaign = _campaign
			AND result IS NOT NULL;

		_result := CAST (_valid_task_num AS FLOAT) / CAST (_total_task_num AS FLOAT);
		RETURN _result * 100;
	END;
$$ LANGUAGE plpgsql;
