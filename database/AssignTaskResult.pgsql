CREATE OR REPLACE FUNCTION assign_task_result() RETURNS trigger AS $$
     DECLARE
        _min_workers integer;
        _task_threshold integer;
        _worker_num integer;

        _best_answer_count integer;
        _best_answer_id integer;
     BEGIN
        -- salva min_workers e task_threshold in delle variabili
        SELECT c.min_worker_num, c.task_threshold INTO _min_workers, _task_threshold
        FROM campaign c JOIN task t ON c.id = t.campaign
        WHERE t.id = NEW.task;

        -- prendi il numero di worker che svolgono il task coinvolto dal trigger
        SELECT count(worker) INTO _worker_num FROM worker_task WHERE task = NEW.task;

        IF _worker_num >= _min_workers THEN
             -- prendi la risposta più data e vedi se raggiunge la percentuale stabilita
            SELECT COUNT(WORKER), chosen_option INTO _best_answer_count, _best_answer_id
            FROM worker_task
            WHERE task = NEW.task
            GROUP BY chosen_option
            ORDER BY COUNT(worker) desc
            LIMIT 1;

            -- se la raggiunge, il task é valido 
            -- e i worker che hanno dato la risposta corretta, ricevono dei punti (QUESTO VIENE FATTO DA UN TRIGGER)
            -- sennò il task non é valido: result rimane invariato (NULL)
            IF _best_answer_count >= CAST (_task_threshold * _worker_num AS FLOAT) / 100 THEN
                UPDATE task SET result = _best_answer_id WHERE id = NEW.task;
            ELSE
                UPDATE task SET result = NULL WHERE id = NEW.task;
            END IF;
        END IF;

        RETURN NULL;
     END;

$$ LANGUAGE plpgsql;


CREATE TRIGGER assign_task_result
AFTER UPDATE OF chosen_option ON worker_task
FOR EACH ROW
EXECUTE PROCEDURE assign_task_result();
