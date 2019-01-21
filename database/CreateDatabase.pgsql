CREATE TYPE keyword_type AS ENUM (
    'EXPERTISE', 'TRAIT'
);

CREATE TABLE users (
    id serial PRIMARY KEY,
    username varchar(25) UNIQUE NOT NULL,
    password varchar(255) NOT NULL
);

CREATE TABLE admin (
    id serial PRIMARY KEY,
    user_id integer REFERENCES users(id)
);

CREATE TABLE worker (
    id serial PRIMARY KEY,
    user_id integer REFERENCES users(id)
);

CREATE TABLE requester (
    id serial PRIMARY KEY,
    user_id integer REFERENCES users(id),
    has_permission boolean DEFAULT false NOT NULL
);

CREATE TABLE campaign (
    id serial PRIMARY KEY,
    name varchar(50) NOT NULL,
    requester integer NOT NULL,
    reg_period date NOT NULL,
    open_date date NOT NULL,
    close_date date NOT NULL,
    task_threshold integer NOT NULL,
    min_worker_num integer NOT NULL,
    finished boolean DEFAULT FALSE NOT NULL
    UNIQUE (name, requester),
    FOREIGN KEY (requester) REFERENCES requester(id) 
);

ALTER TABLE campaign ADD CONSTRAINT date_validity_check CHECK (
    reg_period <= open_date
    AND open_date <= close_date
);

ALTER TABLE campaign ADD CONSTRAINT positive_nums_check CHECK (
    task_threshold > 0 AND task_threshold <= 100
    AND min_worker_num > 0
);

CREATE TABLE worker_campaign (
    worker integer REFERENCES worker(id),
    campaign integer REFERENCES campaign(id),
    score integer NOT NULL,
    PRIMARY KEY(worker, campaign)
);

CREATE TABLE task_option (
    id serial PRIMARY KEY,
    name varchar(100) NOT NULL,
    task integer NOT NULL
);

CREATE TABLE task (
    id serial PRIMARY KEY,
    title varchar(100) NOT NULL,
    description varchar(255) NOT NULL,
    result integer REFERENCES task_option(id),
    campaign integer NOT NULL,
    FOREIGN KEY (campaign) REFERENCES campaign(id)
);

ALTER TABLE task_option
    ADD CONSTRAINT fk_task
    FOREIGN KEY (task)
    REFERENCES task(id);

CREATE TABLE worker_task (
    worker integer REFERENCES worker(id),
    task integer REFERENCES task(id),
    affinity integer NOT NULL,
    chosen_option integer REFERENCES task_option(id),
    PRIMARY KEY (worker, task)
);

CREATE TABLE keyword (
    id serial PRIMARY KEY,
    name varchar(50) NOT NULL,
    kind keyword_type NOT NULL
);

CREATE TABLE task_keyword (
    task integer NOT NULL,
    keyword integer NOT NULL,
    PRIMARY KEY(task, keyword)
);

CREATE TABLE worker_keyword (
    worker integer NOT NULL,
    keyword integer NOT NULL,
    level integer NOT NULL,
    PRIMARY KEY (worker, keyword)
);