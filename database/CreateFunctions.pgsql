CREATE FUNCTION insert_user (name users.username%TYPE, psw users.password%TYPE, usr_type varchar(25))
    RETURNS integer as $$
    DECLARE inserted_id integer;
    BEGIN
        INSERT INTO users(username, password) VALUES (name, crypto.crypt(psw, crypto.gen_salt('bf'))) 
        RETURNING id INTO inserted_id;

        IF FOUND THEN
            CASE usr_type
                WHEN 'admin' THEN
                    INSERT INTO admin(user_id) VALUES (inserted_id);
                WHEN 'worker' THEN
                    INSERT INTO worker(user_id) VALUES (inserted_id);
                WHEN 'requester' THEN
                    INSERT INTO requester(user_id) VALUES (inserted_id);
                ELSE
                    RAISE 'Invalid user type: could be admin, worker or requester';
                    RETURN -1;
            END CASE;
            RETURN inserted_id;
        ELSE
            RETURN inserted_id;
        END IF;
    END;
$$ LANGUAGE plpgsql;
