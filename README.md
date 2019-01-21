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

<b> Algoritmo per l'assegnazione dei task</b>
<p> Ogni worker ha un insieme di task con un valore di competenza da 1 a 5, che viene assegnato durante la registrazione del worker stesso.

Quando un worker decide di partecipare ad una campagna, il database assegna un grado di affinitá ad ogni task per quel worker specifico, semplicemente prendendo la somma dei valori di competenze dei task condivisi con il worker.

<b>esempio</b>: \
Il worker 'Pippo' ha le seguenti competenze: "Cooking: 4", "Music: 3", "Singing 1"; \
La campagna ha tre task (con i seguenti tag):
- task1 (Music, Movies)  3
- task2 (Learning, Engineering)  0
- task3 (Yoga, Cooking, Singing)  5
- task4 (Cooking, Music) 7

Il sistema assegnerá i task nel seguente ordine:
1) task4: affinitá 7 (cooking + music)
2) task3: affinitá 5 (cooking + singing)
3) task1: affinitá 3 (music)
4) task2: affinitá 0 (nessuna competenza in comune)

