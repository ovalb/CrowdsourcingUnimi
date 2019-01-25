CREATE FUNCTION close_campaign(_campaign_id integer) RETURNS boolean AS $$
    DECLARE 
        _close_date date;
        _already_closed boolean;
        _min_workers integer;
        _task_threshold integer;
        _worker_num integer;
        c_task integer;
        _row RECORD;
        _best_answer_count integer;
        _best_answer_id integer;
    BEGIN
        -- se la data di chiusura della campagna non é ancora stata raggiunta, 
        -- non puoi chiudere la campagna -> ritorna FALSE
        SELECT c.close_date INTO _close_date
        FROM campaign c
        WHERE c.id = _campaign_id;

        IF _close_date >= CURRENT_DATE THEN
            RAISE 'Campaign not finished: cannot close it';
            RETURN FALSE;
        END IF;

        -- se la campagna e' gia finita, la funzione esce
        SELECT c.finished INTO _already_closed
        FROM campaign c
        WHERE c.id = _campaign_id;

        IF _already_closed THEN
            RAISE 'Campaign already finished';
            RETURN FALSE;
        END IF;
        
        -- salva min_workers e task_threshold in delle variabili
        SELECT c.min_worker_num INTO _min_workers
        FROM campaign c
        WHERE c.id = _campaign_id;

        SELECT c.task_threshold INTO _task_threshold
        FROM campaign c
        WHERE c.id = _campaign_id;

        -- per ogni task della campagna:
        FOR c_task IN (SELECT id FROM task t WHERE campaign = _campaign_id) LOOP
            SELECT count(worker) INTO _worker_num FROM worker_task WHERE task = c_task;
        
            -- se almeno min_worker_num hanno partecipato al task allora:
            IF _worker_num >= _min_workers THEN
            -- prendi la risposta più data e vedi se raggiunge la percentuale stabilita
            SELECT COUNT(WORKER), chosen_option INTO _best_answer_count, _best_answer_id
            FROM worker_task
            WHERE task = c_task
            GROUP BY chosen_option
            ORDER BY COUNT(worker) desc
            LIMIT 1;

            -- se la raggiunge, il task é valido 
            -- e i worker che hanno dato la risposta corretta, ricevono dei punti (QUESTO VIENE FATTO DA UN TRIGGER)
            -- sennò il task non é valido: result rimane invariato (NULL)
                IF _best_answer_count >= CAST (_task_threshold * _worker_num AS FLOAT) / 100 THEN
                    UPDATE task SET result = _best_answer_id WHERE id = c_task;
                END IF;
            END IF;
        END LOOP;

        UPDATE campaign SET finished = TRUE WHERE id = _campaign_id;
        RETURN TRUE;

    END;
$$ LANGUAGE plpgsql;