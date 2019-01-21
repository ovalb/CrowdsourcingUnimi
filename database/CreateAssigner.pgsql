CREATE FUNCTION assign_task_affinity (_worker_id integer, _campaign_id integer) RETURNS void AS $$
	DECLARE
		campaign_tasks integer[];
		_affinity integer;
		c_task integer;
	BEGIN

	-- 1. prendo i task della campagna che i worker non hanno ancora fatto
	campaign_tasks := ARRAY(
		SELECT t.id
		FROM task t JOIN campaign c ON t.campaign = c.id
		WHERE c.id = _campaign_id
			EXCEPT
		SELECT task
		FROM worker_task wt JOIN worker w ON w.id = wt.worker
		WHERE w.id = _worker_id AND chosen_option IS NOT NULL);

	-- 2. per ogni task: 
	FOREACH c_task IN ARRAY campaign_tasks LOOP
	-- 2.a prendo la lista delle sue keyword che sono in comune con le keywords del worker e
	-- ne sommo i livelli ricavando il grado di affinitá
		SELECT COALESCE(SUM(w.level), 0) INTO _affinity
		FROM task_keyword t INNER JOIN worker_keyword w ON t.keyword = w.keyword
		WHERE t.task = c_task AND w.worker = _worker_id;

	-- 2.b aggiungo il record worker_task con l'affinitá
		INSERT INTO worker_task(worker, task, affinity, chosen_option)
		VALUES (_worker_id, c_task, _affinity, null) 
		ON CONFLICT (worker, task) DO UPDATE SET affinity = _affinity; 
	END LOOP; 
	END;
$$ LANGUAGE plpgsql;
