CREATE FUNCTION assign_score_worker() RETURNS trigger AS $$
    DECLARE 
        _correct_task_num integer;
        _all_campaign_tasks integer;
        _score integer;
        c_worker integer;
    BEGIN
            SELECT count(*) INTO _all_campaign_tasks
            FROM task
            WHERE campaign = NEW.id;

        -- per ogni worker che ha partecipato alla campagna
        FOR c_worker IN (
            SELECT worker FROM worker_campaign WHERE CAMPAIGN = NEW.id GROUP BY worker
        ) LOOP
            -- prende i task corretti che ha fatto in quella campagna 
            SELECT count(*) INTO _correct_task_num
            FROM worker_task w JOIN task t ON w.task = t.id
            WHERE worker = c_worker AND w.chosen_option = t.result AND
                t.campaign = NEW.id;

            -- e ne fa la percentuale rispetto a tutti i task della campagna: quello sará il punteggio
            _score = 100 / _all_campaign_tasks * _correct_task_num;
            -- setta lo score
            UPDATE worker_campaign SET score = _score 
            WHERE worker = c_worker AND campaign = NEW.id;
        END LOOP;

        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;