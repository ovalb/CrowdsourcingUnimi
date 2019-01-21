CREATE TRIGGER assign_score
AFTER UPDATE OF finished ON campaign
FOR EACH ROW
WHEN (NEW.finished)
EXECUTE PROCEDURE assign_score_worker();
