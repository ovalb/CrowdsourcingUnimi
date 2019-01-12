## Crowdsourcing
### Web app Project for the Database course
#### Universitá degli Studi di Milano (2018/19). 

Web app sviluppata utilizzando i linguaggi PHP ed il database Postgresql per il backend, e Javascript, JQuery e Bootstrap per il frontend.

<b>Relational Schema</b>
- USER (id, username, password)
- WORKER(id, user)
- REQUESTER(id, user, permission)
- ADMIN(id, user)
- ADMIN (id, username, password, email)
- CAMPAIGN (id, name, requester, open_date, close_date, reg_period, tasks_threshold, min_worker_num)
- WORKER_CAMPAIGN (worker, campaign, score)
- WORKER_TASK (worker, task, affinity, chosen_option*)
- TASK (id, title, description, result*, campaign)
- TASK_OPTION (id, name, task)
*a task MUST have at least two options. This constraint cant be represented by Relational schema*
- TASK_KEYWORD (task, keyword)\*a task MUST have a keyword associated with it. This - constraint cannot be represented by Relational schema*
- WORKER_KEYWORD(worker, keyword, level)
 *a worker MUST have a keyword associated with it. This  constraint cannot be represented by Relational schema*
- KEYWORD (id, name, kind)

