SELECT setval('shipbuilding_tasks_id_seq', (SELECT MAX(id) FROM shipbuilding_tasks));

